<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
/**
 * @method withLevel(int $level = 1)
 */
class Category extends Model
{
    use SerializeDate;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = ['path' => 'json'];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(CategoryObserver::class);
    }

    /**
     * @param $query
     * @param int $level
     * @return mixed
     */
    public function scopeWithLevel($query, int $level = 1)
    {
        return $query->whereLevel($level);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->with('parent')
            ->latest('sequence');
    }

    /**
     * @param $where
     * @return bool
     */
    public function hasProductUsages($where = []): int
    {
        return Product::whereCategoryId($this->getKey())
                ->where($where)
                ->count();
    }

    /**
     * @param $where
     * @return bool
     */
    public function hasGoodsUsages($where = []): int
    {
        return Goods::whereCategoryId($this->getKey())
                ->where($where)
                ->count();
    }

    /**
     * @param $where
     * @return bool
     */
    public function hasBrandUsages($where = []): int
    {
        return Brand::whereCategoryId($this->getKey())
                ->where($where)
                ->count();
    }
}
