<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LoginController extends Controller
{
    /**
     * Controller Constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to Google for authentication.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google authentication callback.
     */
    public function handleLoginCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            logger()->error($e);

            return redirect('/login');
        }

        // Only allow people with valid email domains to login.
        if (! empty($user->email)) {
            $domain = explode('@', $user->email)[1];
            if (empty($domain) || ! in_array($domain, config('auth.domains'), true)) {
                return redirect()->to('/login');
            }
        } else {
            return redirect()->to('/login');
        }

        // Check if they're an existing user.
        $existing = User::where('google_id', $user->getId())->first();
        if ($existing) {
            // Update the email if they don't match up.
            if ($existing->email !== $user->getEmail()) {
                $existing->email = $user->getEmail();
                $existing->save();
            }

            auth()->login($existing, true);

            return redirect()->to('/');
        }

        // Create a new user from the Google user and fetch their profile from Hermes.
        $newUser = new User();
        $newUser->name = $user->getName();
        $newUser->email = $user->getEmail();
        $newUser->password = Hash::make(Str::random(32));
        $newUser->google_id = $user->getId();

        $newUser->save();

        auth()->login($newUser, true);

        return redirect()->to('/');
    }
}
