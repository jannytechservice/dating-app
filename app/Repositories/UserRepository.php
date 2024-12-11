<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function searchByName(string $query)
    {
        return User::where('name', 'LIKE', "%$query%")->get();
    }

    public function findById(int $id)
    {
        return User::findOrFail($id);
    }
}
