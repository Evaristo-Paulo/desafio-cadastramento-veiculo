<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    protected $fillable = [
        'modelo_id',
        'brand_id',
        'user_id',
        'active',
    ];
}
