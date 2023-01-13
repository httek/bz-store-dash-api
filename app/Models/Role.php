<?php

namespace App\Models;

use App\Models\Traits\PreciseSearch;
use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use SerializeDate, PreciseSearch;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];
}
