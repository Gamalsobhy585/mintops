<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    public function create(User $user)
    {
        return false; 
    }
    
    public function update(User $user, Category $category)
    {
        return false; 
    }
    
    public function delete(User $user, Category $category)
    {
        return false; 
    }
    
}
