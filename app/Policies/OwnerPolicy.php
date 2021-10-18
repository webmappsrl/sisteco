<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy {
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

    public function view(User $user, Owner $model): bool {
        return true;
    }

    public function create(User $user): bool {
        return false;
    }

    public function update(User $user, Owner $model): bool {
        return false;
    }

    public function delete(User $user, Owner $model): bool {
        return false;
    }

    public function restore(User $user, Owner $model): bool {
        return false;
    }

    public function forceDelete(User $user, Owner $model): bool {
        return false;
    }
}
