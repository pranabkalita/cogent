<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\Auth\AuthService;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Requests\LoginRequest;

use Inertia\Inertia;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return Inertia::render('Admin/Auth/Index');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($this->authService->login($credentials)) {
            return redirect()->intended('dashboard');
        }
    }
}
