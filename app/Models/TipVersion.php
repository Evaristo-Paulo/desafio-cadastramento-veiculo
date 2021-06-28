<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipVersion extends Model
{
    protected $fillable = [
        'tip_id',
        'version_id',
        'active',
    ];
}
