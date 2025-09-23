<?php

namespace App\Http\Controllers;

use App\Services\TikTokClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TikTokAuthController extends Controller
{
    public function redirect(\Illuminate\Http\Request $req)
    {
        // create verifier & challenge (TikTok wants HEX(SHA256(verifier)))
        $verifier  = bin2hex(random_bytes(32));                  // 64 chars
        $challenge = hash('sha256', $verifier);                  // hex string

        // store to session for callback
        $state = bin2hex(random_bytes(16));
        $req->session()->put('ttk_state', $state);
        $req->session()->put('ttk_verifier', $verifier);

        // TikTok docs say scopes are comma-separated
        $scopes = env('TIKTOK_SCOPES', 'user.info.basic,video.publish');

        $params = http_build_query([
            'client_key'            => env('TIKTOK_CLIENT_KEY'),
            'response_type'         => 'code',
            'scope'                 => $scopes,                      // comma-separated
            'redirect_uri'          => env('TIKTOK_REDIRECT_URI'),   // must be HTTPS & pre-registered
            'state'                 => $state,
            'code_challenge'        => $challenge,
            'code_challenge_method' => 'S256',
            'disable_auto_auth'    => 1,
        ]);

        logger()->info('TTK redirect', [
            'state' => $state,
            'session_id' => session()->getId(),
            'host' => request()->getHost()
        ]);

        return redirect()->away("https://www.tiktok.com/v2/auth/authorize/?{$params}");
    }

    public function callback(Request $req, TikTokClient $api)
    {
        // Ensure we have params
        $code  = (string) $req->query('code', '');
        $state = (string) $req->query('state', '');   // <-- cast to string
        
        logger()->info('TTK callback', [
            'state'       => (string) $req->query('state', ''),
            'sess_state'  => (string) session('ttk_state', ''),
            'session_id'  => session()->getId(),
            'host'        => $req->getHost(),
        ]);

        abort_unless($code !== '' && $state !== '', 400, 'Missing code/state');

        // 1) Prefer session (consume both)
        $sessState    = (string) $req->session()->pull('ttk_state', '');     // <-- cast
        $sessVerifier = (string) $req->session()->pull('ttk_verifier', '');  // <-- cast

        // 2) If session missing or mismatch, fall back to cache by state
        if ($sessState === '' || $sessVerifier === '' || !hash_equals($sessState, $state)) {
            $cached = cache()->pull("ttk_oauth_{$state}");
            abort_unless($cached && isset($cached['verifier']), 400, 'Invalid state');
            $sessVerifier = (string) $cached['verifier'];
        }

        $userId = \Auth::id() ?? abort(403, 'Sign in first');

        // Exchange with PKCE
        $api->exchangeCode($code, $userId, $sessVerifier);

        return redirect()->route('dashboard')->with('ok', 'TikTok connected.');
    }


}
