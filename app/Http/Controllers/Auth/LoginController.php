<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        if (!auth()->attempt($request->only('name', 'password'))) {
            return redirect()->route('login')->with('status', 'Неверный логин или пароль');
        }

        return redirect()->route('dashboard_index');
    }
}
