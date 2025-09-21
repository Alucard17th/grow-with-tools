<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TikTokToken extends Model
{
    protected $fillable = [
        'user_id','open_id','access_token','refresh_token','expires_at','scope'
    ];

    protected $casts = [
        'access_token' => 'encrypted',
        'refresh_token'=> 'encrypted',
        'expires_at'   => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
