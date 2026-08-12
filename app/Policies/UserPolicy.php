<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * A user may view their own account profile.
     */
    public function view(User $user, User $profile): bool
    {
        return $user->is($profile);
    }

    /**
     * A user may update their own account profile.
     */
    public function update(User $user, User $profile): bool
    {
        return $user->is($profile);
    }

    /**
     * A user may delete their own account profile.
     */
    public function delete(User $user, User $profile): bool
    {
        return $user->is($profile);
    }
}
