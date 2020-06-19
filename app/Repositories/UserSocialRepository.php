<?php

namespace App\Repositories;

use App\Models\UserSocial;
use Illuminate\Support\Collection;

class UserSocialRepository
{
    public function index(Collection $params)
    {
        $userSocial = UserSocial::when($params->get('provider'), function (
            $q
        ) use ($params) {
            return $q->where('provider', $params->get('provider'));
        })
            ->when($params->get('provider_id'), function ($q) use ($params) {
                return $q->where('provider_id', $params->get('provider_id'));
            })
            ->get();

        return $userSocial->toArray();
    }

    public function store($data)
    {
        $userSocial = new UserSocial();
        $userSocial->fill($data);
        $userSocial->save();

        return $userSocial->getKey();
    }
}
