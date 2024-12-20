<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;

class ProfileService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * ProfileService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Search profiles by a query string.
     *
     * @param string $query
     * @return mixed
     */
    public function searchProfiles(string $query)
    {
        return $this->userRepository->searchByName($query);
    }

    /**
     * Get a specific profile by its ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getProfileById(int $id)
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Get the top N popular profiles by conversation count.
     *
     * @param int $count
     * @return mixed
     */
    public function getPopularProfiles(int $count)
    {
        return $this->userRepository->getPopularProfiles($count);
    }
}
