<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\UserSocialRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSocialService
{
    protected $user;
    protected $userSocial;

    public function __construct(
        UserRepository $userRepository,
        UserSocialRepository $userSocialRepository
    ) {
        $this->user = $userRepository;
        $this->userSocial = $userSocialRepository;
    }

    public function store($data)
    {
        $userSocial = $this->userSocial->index(
            collect([
                'provider' => $data['provider'],
                'provider_id' => $data['provider_id']
            ])
        );

        if (empty($userSocial)) {
            $id = DB::transaction(function () use ($data) {
                $user = $this->user->index(
                    collect(['email' => $data['email']])
                );

                if (empty($user)) {
                    $id = $this->user->store([
                        'email' => $data['email'],
                        'name' => $data['name'],
                        'password' => Hash::make(Str::random(10))
                    ]);
                } else {
                    $id = $user[0]['id'];
                }

                $this->userSocial->store([
                    'provider' => $data['provider'],
                    'provider_id' => $data['provider_id'],
                    'user_id' => $id
                ]);

                return $id;
            });

            return $id;
        } else {
            return $userSocial[0]['user_id'];
        }
    }
}
