<?php

namespace App\Policies;

use App\Models\CustomerModel;
use App\Models\User;

/**
 * Who may manage customer accounts from the admin panel.
 *
 * The project has a single admin role today (every row in `users` is an admin;
 * customers authenticate separately through the `customers` guard and can
 * never reach these checks as a User). The abilities are split so a future
 * role system only needs to change this class.
 */
class CustomerPolicy
{
    public function viewAny(User $admin): bool
    {
        return $this->isAdmin($admin);
    }

    public function view(User $admin, CustomerModel $customer): bool
    {
        return $this->isAdmin($admin);
    }

    public function update(User $admin, CustomerModel $customer): bool
    {
        return $this->isAdmin($admin);
    }

    /** Customer accounts can only be created here — public registration is closed. */
    public function create(User $admin): bool
    {
        return $this->isAdmin($admin);
    }

    /** Send a reset link or issue a temporary password. Never reveals the existing password. */
    public function resetPassword(User $admin, CustomerModel $customer): bool
    {
        return $this->isAdmin($admin);
    }

    /** Suspend, ban, disable, reactivate and revoke sessions. */
    public function manageAccess(User $admin, CustomerModel $customer): bool
    {
        return $this->isAdmin($admin);
    }

    private function isAdmin(User $admin): bool
    {
        return $admin->exists;
    }
}
