<?php

namespace App\Policies;

use App\Models\CadastralParcel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CadastralParcelPolicy {
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

    public function view(User $user, CadastralParcel $model): bool {
        return true;
    }

    public function create(User $user): bool {
        return false;
    }

    public function update(User $user, CadastralParcel $model): bool {
        return false;
    }

    public function delete(User $user, CadastralParcel $model): bool {
        return false;
    }

    public function restore(User $user, CadastralParcel $model): bool {
        return false;
    }

    public function forceDelete(User $user, CadastralParcel $model): bool {
        return false;
    }
}
