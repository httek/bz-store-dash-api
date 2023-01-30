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
    public function precise(?string $key, $value, $ignore = 0)
    {
        if (! Schema::hasColumn((new static())->getTable(), $key)) {
            return null;
        }

        $query = static::where($key, $value);
        if ($ignore) $query->where('id', '!=', $ignore);

        return $query->first();
    }
}
