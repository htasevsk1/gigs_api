<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function updateOrDeleteCompany(User $user, int $companyId)
    {
        if (in_array($companyId, $user->companies()->pluck('id')->toArray())) {
            return true;
        }

        return false;
    }

    public function createOrModifyGig(User $user, int $companyId)
    {
        if (in_array($companyId, $user->companies()->pluck('id')->toArray())) {
            return true;
        }

        return false;
    }
}
