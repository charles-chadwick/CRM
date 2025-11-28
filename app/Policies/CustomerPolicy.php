<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Customer $customer): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('create customer');
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->can('update customer');
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->can('delete customer');
    }
}
