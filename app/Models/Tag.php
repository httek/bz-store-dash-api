<?php

namespace App\Models;

use App\Models\Traits\PreciseSearch;
use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SerializeDate, PreciseSearch, SoftDeletes;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];
}
