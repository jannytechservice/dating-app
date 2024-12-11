<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Services\ProfileService;
use App\Http\Requests\Profile\SearchProfileRequest;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    protected $profileService;

    /**
     * Constructor
     *
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Search profiles by a query string.
     *
     * @param SearchProfileRequest $request
     * @return JsonResponse
     */
    public function search(SearchProfileRequest $request)
    {
        $profiles = $this->profileService->searchProfiles($request->query('query', ''));
        return JsonResponse::success('Profiles retrieved successfully.', $profiles, Response::HTTP_OK);
    }

    /**
     * Get a specific profile by its ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $profile = $this->profileService->getProfileById($id);
        if (!$profile) {
            return JsonResponse::error('Profile not found.', null, Response::HTTP_NOT_FOUND);
        }
        return JsonResponse::success('Profile retrieved successfully.', $profile, Response::HTTP_OK);
    }
}
