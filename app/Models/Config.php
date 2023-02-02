<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use SerializeDate;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @param $value
     * @return mixed
     */
    public function getValueAttribute($value)
    {

        switch (($type = $this->getAttributeValue('type'))) {
            case 'array':
            case 'object':
                return json_decode($value, $type == 'array') ?? $value;
            case 'integer':
                return (int)$value;
        }

        return $value;
    }

    /**
     * @param $value
     * @return void
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] =
            is_object($value) || is_array($value)
            ? json_encode($value)
            : $value;
    }
}
