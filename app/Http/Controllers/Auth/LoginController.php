<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('name', 'password'))) {
            return back()->with('status', 'Неверный логин или пароль');
        }

        return redirect()->route('dashboard_index');
    }
}
