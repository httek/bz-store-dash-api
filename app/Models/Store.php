<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SerializeDate, SoftDeletes;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = ['photos' => 'array', 'cash_meta' => 'array'];

    public function deliveryTemplate()
    {
        return $this->hasOne(DeliveryTemplate::class, 'id', 'delivery_template_id');
    }
}
