<?php

namespace App\Http\Controllers;

use App\Services\InstagramClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstagramAuthController extends Controller
{
    public function redirect(InstagramClient $ig)
    {
        // Optional: if you used Cache-based state, generate/store it here instead of session.
        return redirect()->away(InstagramClient::authUrl());
    }

    public function callback(Request $request, InstagramClient $ig)
    {
        // If you used Cache-based state, validate it here.
        abort_if(!$request->filled('code'), 400, 'Missing code from Meta');

        $userId = Auth::id() ?? (int) $request->query('uid', 0); // adapt to your auth flow

        try {
            // This exchanges the code, upgrades to long-lived, resolves Page + IG user id,
            // and then saves (or updates) the row in instagram_tokens.
            $token = $ig->exchangeCode($request->query('code'), $userId);

            // Optional: store a reference on the user, or flash success for the UI
            return redirect()
                ->route('posts.index') // <- your settings page route
                ->with('status', 'Instagram connected as IG user '.$token->ig_user_id);
        } catch (\Throwable $e) {
            dd($e);
            report($e);
            return redirect()
                ->route('posts.index')
                ->with('error', 'Instagram connect failed: '.$e->getMessage());
        }
    }
}
