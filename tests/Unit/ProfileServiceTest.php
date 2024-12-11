<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ProfileService;
use Mockery;
use App\Contracts\UserRepositoryInterface;

class ProfileServiceTest extends TestCase
{
    protected $profileService;
    protected $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->profileService = new ProfileService($this->userRepositoryMock);
    }

    public function test_search_profiles()
    {
        $query = 'John';
        $expectedProfiles = [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'John Smith'],
        ];

        $this->userRepositoryMock
            ->shouldReceive('searchByName')
            ->with($query)
            ->once()
            ->andReturn($expectedProfiles);

        $result = $this->profileService->searchProfiles($query);

        $this->assertEquals($expectedProfiles, $result);
    }

    public function test_get_profile_by_id()
    {
        $id = 1;
        $expectedProfile = ['id' => 1, 'name' => 'John Doe'];

        $this->userRepositoryMock
            ->shouldReceive('findById')
            ->with($id)
            ->once()
            ->andReturn($expectedProfile);

        $result = $this->profileService->getProfileById($id);

        $this->assertEquals($expectedProfile, $result);
    }

    public function test_get_profile_by_id_not_found()
    {
        $id = 999;

        $this->userRepositoryMock
            ->shouldReceive('findById')
            ->with($id)
            ->once()
            ->andReturn(null);

        $result = $this->profileService->getProfileById($id);

        $this->assertNull($result);
    }
}
