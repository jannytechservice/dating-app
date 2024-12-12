<?php

namespace App\Contracts;

use App\Models\User;

/**
 * Interface UserRepositoryInterface
 *
 * This interface defines methods for managing user data.
 */
interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function createUser(array $data);

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email);

    /**
     * Search for users by a name query string.
     *
     * @param string $query
     * @return mixed
     */
    public function searchByName(string $query);

    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return User
     */
    public function findById(int $id);

    /**
     * Get the top N users by conversation count.
     *
     * @param int $count
     * @return mixed
     */
    public function getPopularProfiles(int $count);
}
