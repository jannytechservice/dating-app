<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\ConversationParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository
 *
 * This class provides methods for interacting with the User model.
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user with the given data.
     *
     * @param array<string, mixed> $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    /**
     * Search for users by name using a query string.
     *
     * @param string $query
     * @return Collection<int, User>
     */
    public function searchByName(string $query): Collection
    {
        return User::where('name', 'LIKE', "%$query%")->get();
    }

    /**
     * Find a user by their ID or fail.
     *
     * @param int $id
     * @return User
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Get the top N users by conversation count.
     *
     * @param int $count
     * @return Collection<int, User>
     */
    public function getPopularProfiles(int $count): Collection
    {
        $usersTable = User::tableName();
        $conversationParticipantsTable = ConversationParticipant::tableName();
    
        return User::select("$usersTable.id", "$usersTable.name", "$usersTable.email", DB::raw("COUNT($conversationParticipantsTable.conversation_id) as conversation_count"))
            ->join("$conversationParticipantsTable as cp", "$usersTable.id", '=', 'cp.user_id')
            ->groupBy("$usersTable.id", "$usersTable.name", "$usersTable.email")
            ->orderByDesc('conversation_count')
            ->limit($count)
            ->get();
    }
}
