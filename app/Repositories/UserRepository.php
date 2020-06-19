<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository
{
    public function all(Collection $params)
    {
        $users = User::when($params->get('email'), function ($q) use ($params) {
            return $q->where('email', $params->get('email'));
        });

        return $this->paginate($users, $params);
    }

    public function store($data)
    {
        $user = new User();
        $user->fill($data);
        $user->save();

        return $user->getKey();
    }

    public function findById($id)
    {
        $user = User::find($id);

        if ($user) {
            return $user->toArray();
        }

        return null;
    }

    public function update($data, $id)
    {
        $user = User::find($id);

        $user->fill($data);
        $user->update();

        return $user->getKey();
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return true;
    }
}
