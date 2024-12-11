<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function findByEmail(string $email);
    public function searchByName(string $query);
    public function findById(int $id);
}
