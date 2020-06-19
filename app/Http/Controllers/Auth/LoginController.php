<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->get('email'))->first();
        if ($user) {
            if (Hash::check($request->get('password'), $user->password)) {
                $token = $user->createToken('accessToken');

                return response()->json(
                    [
                        'type' => 'Bearer',
                        'access_token' => $token->plainTextToken
                    ],
                    200
                );
            } else {
                return response()->json(['error' => __('auth.failed')], 401);
            }
        } else {
            return response()->json(['error' => __('auth.failed')], 401);
        }
    }

    public function logout(Request $request)
    {
        $request
            ->user()
            ->tokens()
            ->delete();

        return response()->json(__('auth.logout'), 201);
    }
}
