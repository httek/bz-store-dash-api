<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use App\Services\TokenService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    use SerializeDate;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $hidden = ['password', 'created_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id')
            ->select(['id', 'name']);
    }

    /**
     * @return bool
     */
    public function disabled(): bool
    {
        return $this->getAttributeValue('status') == 0;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePasswd(string $password): bool
    {
        return Hash::check($password, $this->getAttributeValue('password'));
    }

    /**
     * @param int $ttl
     * @return $this
     */
    public function issueToken(int $ttl = 0)
    {
        $this->setAttribute('token', TokenService::issue($this, $ttl));

        return $this;
    }
}
