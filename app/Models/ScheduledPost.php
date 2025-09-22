<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledPost extends Model
{
    protected $fillable = [
        'user_id','product','title','caption','video_source','video_url','file_path',
        'cover_ts_ms','privacy','disable_duet','disable_stitch','disable_comment',
        'brand_organic_toggle','publish_at','status','publish_id','tiktok_post_url','error',
        'platform',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'disable_duet' => 'bool',
        'disable_stitch' => 'bool',
        'disable_comment' => 'bool',
        'brand_organic_toggle' => 'bool',
    ];

    public function scopeDue($q) {
        return $q->whereIn('status', ['queued','draft'])
                 ->where('publish_at', '<=', now());
    }

    public function user() { return $this->belongsTo(User::class); }
}
