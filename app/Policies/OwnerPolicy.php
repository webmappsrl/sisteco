<?php

namespace App\Policies;

use App\Models\CadastralParcel;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

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

    /**
     * Determine is the user can attach cadastral parcels to the owner
     *
     * @param User  $user
     * @param Owner $model
     *
     * @return bool
     */
    public function attachAnyCadastralParcel(User $user, Owner $model): bool {
        return false;
    }

    /**
     * Determine is the user can detach cadastral parcels to the owner
     *
     * @param User  $user
     * @param Owner $model
     *
     * @return bool
     */
    public function detachAnyCadastralParcel(User $user, Owner $model): bool {
        return false;
    }

    /**
     * Determine is the user can attach projects to the owner
     *
     * @param User  $user
     * @param Owner $model
     *
     * @return bool
     */
    public function attachAnyProject(User $user, Owner $model): bool {
        return false;
    }

    /**
     * Determine is the user can detach projects to the owner
     *
     * @param User  $user
     * @param Owner $model
     *
     * @return bool
     */
    public function detachAnyProject(User $user, Owner $model): bool {
        return false;
    }
}
