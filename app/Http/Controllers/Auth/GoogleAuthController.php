<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the customer to Google's OAuth 2.0 authorization screen.
     * Note: This route is strictly for Customers, not Sellers.
     */
    public function redirectToGoogle(Request $request): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->back()->with('error', 'Google Sign-In is not configured yet. Please configure GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in the environment.');
        }

        // Store intended redirect URL (e.g. checkout or course page)
        $redirectTo = $request->input('redirect_to', $request->query('redirect_to'));
        if ($redirectTo && (str_starts_with($redirectTo, '/') || str_starts_with($redirectTo, url('/')))) {
            $request->session()->put('google_redirect_to', $redirectTo);
        }

        // Generate CSRF state
        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $params = [
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid profile email',
            'state'         => $state,
            'access_type'   => 'offline',
            'prompt'        => 'select_account',
        ];

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
    }

    /**
     * Handle the callback returned from Google OAuth.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        if ($request->has('error')) {
            $error = $request->get('error_description', $request->get('error'));
            return redirect()->route('customer.login')->with('error', 'Google sign-in was cancelled: ' . $error);
        }

        $code = $request->input('code');
        $state = $request->input('state');
        $savedState = $request->session()->pull('google_oauth_state');

        if (empty($code) || empty($state) || $state !== $savedState) {
            return redirect()->route('customer.login')->with('error', 'Invalid Google authorization state. Please try signing in again.');
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect');

        try {
            // Exchange authorization code for access token
            $tokenResponse = Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/token', [
                'code'          => $code,
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri'  => $redirectUri,
                'grant_type'    => 'authorization_code',
            ]);

            if ($tokenResponse->failed()) {
                Log::error('Google OAuth token exchange failed', ['body' => $tokenResponse->body()]);
                return redirect()->route('customer.login')->with('error', 'Failed to authenticate with Google. Please try again.');
            }

            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'] ?? null;

            if (empty($accessToken)) {
                return redirect()->route('customer.login')->with('error', 'No access token received from Google.');
            }

            // Fetch Google user profile
            $userResponse = Http::withToken($accessToken)->timeout(15)->get('https://www.googleapis.com/oauth2/v3/userinfo');

            if ($userResponse->failed()) {
                Log::error('Google Userinfo fetch failed', ['body' => $userResponse->body()]);
                return redirect()->route('customer.login')->with('error', 'Failed to retrieve profile details from Google.');
            }

            $googleUser = $userResponse->json();
            $googleId = $googleUser['sub'] ?? null;
            $email = strtolower(trim($googleUser['email'] ?? ''));
            $name = $googleUser['name'] ?? ($googleUser['given_name'] ?? 'Customer');
            $avatar = $googleUser['picture'] ?? null;

            if (empty($email)) {
                return redirect()->route('customer.login')->with('error', 'Google account did not provide an email address.');
            }

            // Look up existing user by google_id or email
            $user = User::where('google_id', $googleId)
                ->orWhereRaw('LOWER(email) = ?', [$email])
                ->first();

            if ($user) {
                // Strictly enforce: Customer only (NOT seller or admin)
                if ($user->isSeller()) {
                    return redirect()->route('customer.login')->with('error', 'This Google account (' . $user->email . ') is registered as a Seller (' . $user->name . '). Google Sign-In on customer portal is restricted to Customers only. Please sign in via the Seller portal.');
                }

                if ($user->isAdmin()) {
                    return redirect()->route('customer.login')->with('error', 'This account is registered as an Administrator. Please log in via the Admin panel.');
                }

                // If user is a customer, link google_id and update avatar if not set
                $updates = [];
                if (empty($user->google_id) && !empty($googleId)) {
                    $updates['google_id'] = $googleId;
                }
                if (empty($user->avatar) && !empty($avatar)) {
                    $updates['avatar'] = $avatar;
                }
                if (empty($user->email_verified_at)) {
                    $updates['email_verified_at'] = now();
                }

                if (!empty($updates)) {
                    $user->update($updates);
                }
            } else {
                // New user - automatically register as Customer
                $user = User::create([
                    'name'              => $name,
                    'email'             => $email,
                    'google_id'         => $googleId,
                    'avatar'            => $avatar,
                    'role'              => 'customer',
                    'profession'        => 'Student / Learner',
                    'password'          => Hash::make(Str::random(32)),
                    'email_verified_at' => now(),
                ]);
            }

            // Log in customer
            Auth::guard('web')->login($user, true);

            $destination = $request->session()->pull('google_redirect_to', route('home'));
            return redirect($destination)->with('success', 'Welcome, ' . $user->name . '! Signed in successfully with Google.');

        } catch (Exception $e) {
            Log::error('Google OAuth exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('customer.login')->with('error', 'An error occurred during Google sign-in: ' . $e->getMessage());
        }
    }
}

