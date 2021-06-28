<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $fillable = [
        'name', 'slug', 'type_id','brand_id','active'
    ];
}
