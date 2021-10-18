<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
    }

    public function viewAny(User $user): bool {
        return true;
    }

    public function view(User $user, User $model): bool {
        return true;
    }

    public function create(User $user): bool {
        return $user->email === 'team@webmapp.it';
    }

    public function update(User $user, User $model): bool {
        return $user->email === 'team@webmapp.it';
    }

    public function delete(User $user, User $model): bool {
        return $user->email === 'team@webmapp.it';
    }

    public function restore(User $user, User $model): bool {
        return $user->email === 'team@webmapp.it';
    }

    public function forceDelete(User $user, User $model): bool {
        return $user->email === 'team@webmapp.it';
    }
}
