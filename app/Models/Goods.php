<?php

namespace App\Models;

use App\Models\Traits\PreciseSearch;
use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes, SerializeDate, PreciseSearch;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'covers' => 'array',
        'detail' => 'array',
        'tags' => 'array',
    ];

    /**
     * @var string[]
     */
    protected $hidden = ['deleted_at'];

    public function scopeSale($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->hasOne(Admin::class, 'id', 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->select(['id', 'name', 'covers']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'store_id')
            ->select(['id', 'name', 'cover']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')
            ->select(['id', 'name', 'cover']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'id', 'delivery_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id')
            ->select(['id', 'name', 'cover']);
    }

    /**
     * @param $value
     * @return void
     */
    public function setSalePriceAttribute($value)
    {
        $value && $this->attributes['sale_price'] = intval($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getSalePriceAttribute($value)
    {
        return $value ? $value / 100 : $value;
    }

    /**
     * @param $value
     * @return void
     */
    public function setOriginPriceAttribute($value)
    {
        $value && $this->attributes['origin_price'] = intval($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getOriginPriceAttribute($value)
    {
        return $value ? $value / 100 : $value;
    }
}
