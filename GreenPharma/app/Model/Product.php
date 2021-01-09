<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'industria','unidade','cod','ean','descrition','provider',
    ];
}
