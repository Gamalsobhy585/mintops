<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true; // Customize according to your needs
    }

    public function view(User $user, Category $category)
    {
        return true; // Customize according to your needs
    }

    public function create(User $user)
    {
        return $user->isLeader(); // Assuming you have a method to check if user is a leader
    }

    public function update(User $user, Category $category)
    {
        return $user->isLeader();
    }

    public function delete(User $user, Category $category)
    {
        return $user->isLeader();
    }

    public function restore(User $user, Category $category)
    {
        return $user->isLeader();
    }

    public function forceDelete(User $user, Category $category)
    {
        return false; // Disable force delete
    }
}
