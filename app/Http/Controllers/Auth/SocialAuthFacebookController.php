<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserSocialService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthFacebookController extends Controller
{
    protected $userSocial;

    public function __construct(UserSocialService $userSocialService)
    {
        $this->userSocial = $userSocialService;
    }

    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')
            ->stateless()
            ->redirect();
    }

    public function handleProviderCallback()
    {
        $userSocialite = Socialite::driver('facebook')
            ->stateless()
            ->user();

        $userId = $this->userSocial->store([
            'provider' => 'facebook',
            'provider_id' => $userSocialite->id,
            'name' => $userSocialite->name,
            'email' => $userSocialite->email
        ]);

        $user = User::find($userId);

        return response()->json(
            [
                'access_token' => $user->createToken('authToken')->accessToken,
                'token_type' => 'Bearer'
            ],
            200
        );
    }
}
