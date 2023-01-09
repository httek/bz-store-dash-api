<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Schema;

trait PreciseSearch
{
    /**
     * @param string $key
     * @param $value
     * @return PreciseSearch|null
     */
    public function precise(?string $key, $value)
    {
        if (! Schema::hasColumn((new static())->getTable(), $key)) {
            return null;
        }


        return static::where($key, $value)->first();
    }
}
