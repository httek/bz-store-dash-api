<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes, SerializeDate;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return mixed
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
