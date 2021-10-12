<?php

namespace App\Http\Services\Admin\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login($credentials): bool
    {
        return Auth::attempt($credentials);
    }
}
