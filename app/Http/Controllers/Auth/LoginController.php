<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        if (!Auth::attempt($request->only('name', 'password'))) {
            return back()->with('status', 'Неверный логин или пароль');
        }

        return redirect()->route('dashboard_index');
    }
}
