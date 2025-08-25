<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function providerCallback(string $provider)
    {
        try {
            $social_user = Socialite::driver($provider)->user();

            // First Find Social Account
            $account = SocialAccount::where([
                'provider_name' => $provider,
                'provider_id' => $social_user->getId(),
            ])->first();

            // If Social Account Exist then Find User and Login
            if ($account) {
                auth()->login($account->user);

                return redirect()->route('customer.dashboard');
            }

            // If User not get then create new user
            $user = User::updateOrCreate([
                'email' => $social_user->getEmail(),
                'username' => User::where('username', str($social_user->getEmail())->before('@'))->first() ? str($social_user->getEmail())->before('@') : str($social_user->getEmail())->before('@').mt_rand(1, 5),
            ], [
                'name' => $social_user->getName(),
                'user_type' => 'customer',
                'password' => 'ponnobd',
            ]);

            $user->markEmailAsVerified();

            // Update or Create Social Accounts
            $user->socialAccounts()->updateOrCreate([
                'provider_id' => $social_user->getId(),
                'provider_name' => $provider,
            ]);

            // Login
            auth()->login($user);

            return redirect()->route('customer.dashboard');
        } catch (\Exception $e) {
            // throw $e;
            return redirect()->route('login')->with('error', 'Sorry, something went wrong!');
        }
    }
}
