<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;

class DeliveryTemplate extends Model
{
    use SerializeDate;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = ['meta' => 'array'];

    /**
     * @param $cost
     * @return void
     */
    public function setCostAttribute($cost)
    {
        $this->attributes['cost'] = $cost ? $cost * 100 : 0;
    }

    public function getCostAttribute($cost)
    {
        return $cost ? $cost / 100 : 0;
    }
}
