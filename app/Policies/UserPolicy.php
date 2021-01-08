<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Request;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id && $currentUser->tokenCan('update');
    }

    public function destroy(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id && $currentUser->tokenCan('delete');
    }
}
