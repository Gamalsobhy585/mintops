<?php

namespace App\Services;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): User;
    public function login(array $data): ?string;
    public function logout(User $user): void;
}
