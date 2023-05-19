<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $vpnIp = config('auth.alley_vpn');

        // Ensure the user is logged in and not on the VPN.
        if (! auth()->check() && $request->ip() !== $vpnIp) {
            return redirect('/auth/login');
        }

        // Check if there is a link with the given URL path (the hash).
        $link = Link::find($request->path());

        // If there is no link, return a 404.
        if (! $link) {
            abort(404);
        }

        // Redirect the user to the URL.
        return redirect($link->url);
    }
}
