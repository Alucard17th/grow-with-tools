<?php

namespace App\Services;

use App\Models\InstagramToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class InstagramClient
{
    private string $graphBase;
    private string $graphVersion;

    public function __construct()
    {
        $this->graphVersion = config('services.instagram.version', env('IG_GRAPH_VERSION', 'v19.0'));
        $this->graphBase    = rtrim(config('services.instagram.base', env('IG_GRAPH_BASE', "https://graph.facebook.com/{$this->graphVersion}")), '/');
    }

    /**
     * Optional: Build a Facebook Login URL (for getting a short-lived token).
     * You’ll still need to exchange it for a long-lived token after auth.
     */
    public static function authUrl(): string
    {
        $params = http_build_query([
            'client_id'     => env('FB_APP_ID'),
            'redirect_uri'  => env('FB_REDIRECT_URI'),
            'scope'         => 'instagram_basic,instagram_content_publish,pages_show_list,pages_read_engagement',
            'response_type' => 'code',
            'state'         => csrf_token(),
        ]);

        return "https://www.facebook.com/dialog/oauth?{$params}";
    }

    /**
     * Exchange auth code -> short-lived token -> long-lived token,
     * then resolve IG User ID (the {ig-user-id} for publishing).
     */
    public function exchangeCode(string $code, int $userId): InstagramToken
    {
        // Step 1: Code -> short-lived user access token
        $short = Http::asForm()->get("{$this->graphBase}/oauth/access_token", [
            'client_id'     => env('FB_APP_ID'),
            'client_secret' => env('FB_APP_SECRET'),
            'redirect_uri'  => env('FB_REDIRECT_URI'),
            'code'          => $code,
        ])->throw()->json();

        // Step 2: Short-lived -> long-lived
        $long = Http::asForm()->get("{$this->graphBase}/oauth/access_token", [
            'grant_type'        => 'fb_exchange_token',
            'client_id'         => env('FB_APP_ID'),
            'client_secret'     => env('FB_APP_SECRET'),
            'fb_exchange_token' => $short['access_token'],
        ])->throw()->json();

        $accessToken = $long['access_token'];
        $expiresIn   = $long['expires_in'] ?? (60 * 24 * 60 * 60); // ~60 days in seconds

        // Step 3: Resolve the Facebook Page(s) and Instagram Business Account ID
        // 3a) Get user pages
        $pages = Http::withToken($accessToken)
            ->get("{$this->graphBase}/me/accounts", ['fields' => 'id,name,access_token'])
            ->throw()->json();

        // choose first page or find the one you want; here: first
        $page = collect($pages['data'] ?? [])->first();
        if (!$page) {
            throw new \RuntimeException('No Facebook Pages found on this user.');
        }

        // 3b) From page -> instagram_business_account
        $pageDetail = Http::withToken($accessToken)
            ->get("{$this->graphBase}/{$page['id']}", ['fields' => 'instagram_business_account'])
            ->throw()->json();

        $igUserId = data_get($pageDetail, 'instagram_business_account.id');
        if (!$igUserId) {
            throw new \RuntimeException('Selected Page has no linked Instagram Business account.');
        }

        return InstagramToken::updateOrCreate(
            ['user_id' => $userId],
            [
                'fb_page_id'    => $page['id'],
                'ig_user_id'    => $igUserId,
                'access_token'  => $accessToken,
                'expires_at'    => Carbon::now()->addSeconds($expiresIn),
            ]
        );
    }

    /**
     * Long-lived tokens last ~60 days. You can refresh by re-exchanging.
     * Here we just check expiry and (optionally) re-exchange if near expiry.
     */
    public function ensureFreshToken(InstagramToken $token): InstagramToken
    {
        if (now()->addDays(5)->lt($token->expires_at)) {
            return $token;
        }

        // Facebook doesn’t provide a “refresh long-lived” endpoint that always returns a new token;
        // many apps just re-run the fb_exchange_token with the current token and extend the expiry.
        $res = Http::asForm()->get("{$this->graphBase}/oauth/access_token", [
            'grant_type'        => 'fb_exchange_token',
            'client_id'         => env('FB_APP_ID'),
            'client_secret'     => env('FB_APP_SECRET'),
            'fb_exchange_token' => $token->access_token,
        ])->throw()->json();

        $token->update([
            'access_token' => $res['access_token'],
            'expires_at'   => now()->addSeconds($res['expires_in'] ?? (60 * 24 * 60 * 60)),
        ]);

        return $token->fresh();
    }

    /**
     * Step 1: Create a media container (VIDEO or REELS).
     * For Reels: media_type='REELS'; for feed video: media_type='VIDEO'
     * Required: public video_url and caption (optional).
     * Optional: 'thumb_offset' (seconds) to pick a cover frame.
     */
    public function createMediaContainer(string $igUserId, string $accessToken, array $payload): array
    {
        return Http::withToken($accessToken)
            ->asForm()
            ->post("{$this->graphBase}/{$igUserId}/media", $payload)
            ->throw()
            ->json();
    }

    /**
     * Step 2: Publish the container.
     */
    public function publishMedia(string $igUserId, string $accessToken, string $creationId): array
    {
        return Http::withToken($accessToken)
            ->asForm()
            ->post("{$this->graphBase}/{$igUserId}/media_publish", ['creation_id' => $creationId])
            ->throw()
            ->json();
    }

    /**
     * Poll container status until it’s FINISHED (or ERROR).
     */
    public function fetchContainerStatus(string $creationId, string $accessToken): array
    {
        return Http::withToken($accessToken)
            ->get("{$this->graphBase}/{$creationId}", ['fields' => 'id,status_code,status'])
            ->throw()
            ->json();
    }
}
