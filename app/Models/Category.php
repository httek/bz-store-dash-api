<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;

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
    protected $appends = ['label'];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(CategoryObserver::class);
    }

    /**
     * @return mixed
     */
    public function getLabelAttribute()
    {
        return $this->getAttributeValue('name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentNode()
    {
        return $this->hasOne(self::class, 'id', 'parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent', 'id')
            ->with('parentNode')
            ->latest('sequence');
    }
}
