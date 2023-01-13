<?php

namespace App\Models;

use App\Models\Traits\IfExists;
use App\Models\Traits\PreciseSearch;
use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SerializeDate, SoftDeletes, IfExists, PreciseSearch;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = ['covers' => 'json'];

    /**
     * @var string[]
     */
    protected $hidden = ['deleted_at'];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(
            fn(Product $product) => $product->uuid = strtoupper(uniqid(date('y')))
        );
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany(Goods::class, 'product_id', 'id');
    }
}
