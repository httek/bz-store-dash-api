<?php

namespace App\Models;

use App\Models\Traits\PreciseSearch;
use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SerializeDate, SoftDeletes, PreciseSearch;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];
}
