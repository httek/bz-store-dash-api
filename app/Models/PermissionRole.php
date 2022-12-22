<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;


    /**
     * @var bool
     */
    public $timestamps = false;
}
