<?php

namespace App\Policies;

use App\Models\Research;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResearchPolicy {
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

    public function view(User $user, Research $model): bool {
        return true;
    }

    public function create(User $user): bool {
        return false;
    }

    public function update(User $user, Research $model): bool {
        return false;
    }

    public function delete(User $user, Research $model): bool {
        return false;
    }

    public function restore(User $user, Research $model): bool {
        return false;
    }

    public function forceDelete(User $user, Research $model): bool {
        return false;
    }
}
