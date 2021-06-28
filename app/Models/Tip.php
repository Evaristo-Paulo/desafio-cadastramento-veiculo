<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    protected $fillable = [
        'modelo_id',
        'user_id',
        'active',
    ];
}
