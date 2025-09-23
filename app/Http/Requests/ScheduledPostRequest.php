<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduledPostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product' => 'required|string|max:64',
            'title'   => 'nullable|string|max:120',
            'caption' => 'nullable|string|max:2200',

            'platform' => 'required|in:tiktok,instagram',

            'video_source' => 'required|in:PULL_FROM_URL,FILE_UPLOAD',
            'video_url'    => 'required_if:video_source,PULL_FROM_URL|url',
            'file'         => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:512000',

            'cover_ts_ms'  => 'nullable|integer|min:0',
            'privacy'      => 'required|in:PUBLIC_TO_EVERYONE,MUTUAL_FOLLOW_FRIENDS,FOLLOWER_OF_CREATOR,SELF_ONLY',
            'disable_duet'   => 'sometimes|boolean',
            'disable_stitch' => 'sometimes|boolean',
            'disable_comment'=> 'sometimes|boolean',
            'brand_organic_toggle' => 'sometimes|boolean',
            'publish_at'    => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required_if' => 'Please choose a video file to upload.',
            'video_url.required_if' => 'Please provide a video URL when using PULL_FROM_URL.',
        ];
    }
}
