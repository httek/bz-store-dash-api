<?php

namespace App\Models;

use App\Models\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SerializeDate, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = ['images' => 'array'];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
