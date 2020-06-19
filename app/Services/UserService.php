<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

    public function index(Collection $params)
    {
        return $this->user->all($params);
    }

    public function store($data)
    {
        $id = DB::transaction(function () use ($data) {
            $user = $this->user->all(collect(['email' => $data['email']]));

            if (!empty($user)) {
                throw new Exception(__('errors.email_already_registred'), 401);
            }

            $id = $this->user->store($data);

            return $id;
        });

        return $this->user->findById($id);
    }

    public function show($id)
    {
        return $this->user->findById($id);
    }

    public function update($data, $id)
    {
        $id = DB::transaction(function () use ($data, $id) {
            $user = $this->user->findById($id);

            if (!$user) {
                throw new Exception(__('errors.user_not_found'));
            }

            return $this->user->update($data, $id);
        });

        return $this->user->findById($id);
    }

    public function delete($id)
    {
        $user = $this->user->findById($id);

        if (!$user) {
            throw new Exception(__('errors.user_not_found'));
        }

        return $this->user->delete($id);
    }
}
