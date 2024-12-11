<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_profiles_successfully()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Jane Doe']);
        User::factory()->create(['name' => 'John Smith']);

        $this->actingAs($user)
            ->getJson('/api/profile/search?query=John')
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Profiles retrieved successfully.',
                'data' => [
                    ['name' => 'John Doe'],
                    ['name' => 'John Smith'],
                ],
            ]);
    }

    public function test_search_profiles_no_results()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/profile/search?query=Nonexistent')
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Profiles retrieved successfully.',
                'data' => [],
            ]);
    }

    public function test_get_profile_successfully()
    {
        $user = User::factory()->create();
        $profile = User::factory()->create();

        $this->actingAs($user)
            ->getJson("/api/profile/{$profile->id}")
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Profile retrieved successfully.',
                'data' => [
                    'id' => $profile->id,
                    'name' => $profile->name,
                ],
            ]);
    }

    public function test_get_profile_not_found()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/profile/999')
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Profile not found.',
            ]);
    }
}
