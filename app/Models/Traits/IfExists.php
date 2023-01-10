<?php

namespace App\Models\Traits;

trait IfExists
{
    /**
     * @param $token
     * @param string $field
     * @param array $where
     * @return bool
     */
    public function ifExists($token, string $field = 'name', array $where = []): bool
    {
        return $token != $this->getAttributeValue($field) &&
            static::where($field, $token)->where($where)->exists();
    }
}
