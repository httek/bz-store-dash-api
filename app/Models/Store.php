<?php

namespace App\Models;

use App\Models\Traits\PreciseSearch;
use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SerializeDate, SoftDeletes, PreciseSearch;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = ['photos' => 'array', 'cash_meta' => 'json'];

    /**
     * @var string[]
     */
    protected $hidden = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->hasOne(Admin::class, 'id', 'owner_id');
    }

    /**
     * @param $value
     * @return void
     */
    public function setDeductAttribute($value)
    {
        $this->attributes['deduct'] = $value ? $value * 100 : 0;
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getDeductAttribute($value)
    {
        return $value ? $value / 100 : 0;
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public function getCashMetaAttribute($value)
    {
        if (is_null($value)) return new \stdClass;

        return json_decode($value);
    }
}
