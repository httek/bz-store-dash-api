<?php

namespace App\Models;

use App\Models\Traits\PreciseSearch;
use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use SerializeDate, PreciseSearch;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $hidden = ['updated_at', 'created_at'];

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
