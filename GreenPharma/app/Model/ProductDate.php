<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductDate extends Model
{
    protected $fillable = [
        'fk_product', 'competence', 'valor',
    ];
}
