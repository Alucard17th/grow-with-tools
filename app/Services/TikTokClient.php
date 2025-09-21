<?php

namespace App\Services;

use App\Models\TikTokToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TikTokClient
{
    private string $base;

    public function __construct()
    {
        $this->base = rtrim(config('services.tiktok.base', env('TIKTOK_API_BASE')), '/');
    }

    public static function authUrl(): string
    {
        $params = http_build_query([
            'client_key'    => env('TIKTOK_CLIENT_KEY'),
            'response_type' => 'code',
            'scope'         => str_replace(',', ' ', env('TIKTOK_SCOPES')),
            'redirect_uri'  => env('TIKTOK_REDIRECT_URI'),
            'state'         => csrf_token(),
        ]);
        return "https://www.tiktok.com/v2/auth/authorize/?{$params}";
    }

    public function exchangeCode(string $code, int $userId): TikTokToken
    {
        $res = Http::asForm()->post("{$this->base}/v2/oauth/token/", [
            'client_key'    => env('TIKTOK_CLIENT_KEY'),
            'client_secret' => env('TIKTOK_CLIENT_SECRET'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => env('TIKTOK_REDIRECT_URI'),
        ])->throw()->json();

        return TikTokToken::updateOrCreate(
            ['user_id' => $userId],
            [
                'open_id'       => $res['open_id'] ?? null,
                'access_token'  => $res['access_token'],
                'refresh_token' => $res['refresh_token'],
                'expires_at'    => Carbon::now()->addSeconds($res['expires_in'] ?? 3600),
                'scope'         => $res['scope'] ?? null,
            ]
        );
    }

    public function ensureFreshToken(TikTokToken $token): TikTokToken
    {
        if (now()->addMinutes(5)->lt($token->expires_at)) return $token;

        $res = Http::asForm()->post("{$this->base}/v2/oauth/token/", [
            'client_key'    => env('TIKTOK_CLIENT_KEY'),
            'client_secret' => env('TIKTOK_CLIENT_SECRET'),
            'refresh_token' => $token->refresh_token,
            'grant_type'    => 'refresh_token',
        ])->throw()->json();

        $token->update([
            'access_token'  => $res['access_token'],
            'refresh_token' => $res['refresh_token'] ?? $token->refresh_token,
            'expires_at'    => now()->addSeconds($res['expires_in'] ?? 3600),
            'scope'         => $res['scope'] ?? $token->scope,
        ]);

        return $token->fresh();
    }

    public function directPostInit(array $payload, TikTokToken $token): array
    {   
        return Http::withToken($token->access_token)
            ->acceptJson()->asJson()
            ->post("{$this->base}/v2/post/publish/video/init/", $payload)
            ->throw()->json();
    }

    public function fetchPublishStatus(string $publishId, TikTokToken $token): array
    {
        return Http::withToken($token->access_token)
            ->acceptJson()->asJson()
            ->post("{$this->base}/v2/post/publish/status/fetch/", ['publish_id' => $publishId])
            ->throw()->json();
    }
}
