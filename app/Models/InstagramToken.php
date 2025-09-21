<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramToken extends Model
{
    protected $fillable = [
        'user_id','fb_page_id','ig_user_id','access_token','expires_at',
    ];
    protected $dates = ['expires_at'];
}
