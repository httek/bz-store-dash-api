<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $hidden = ['id', 'updated_at', 'created_at'];

    /**
     * @var string[]
     */
    protected $casts = ['meta' => 'json'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->latest('sequence')
            ->with('children');
    }
}
