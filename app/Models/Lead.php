<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    //

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'status',
        'error'
    ];
}
