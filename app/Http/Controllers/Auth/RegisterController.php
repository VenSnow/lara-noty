<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        $this->validate($request, [
           'name' => 'required|min:3|max:25|unique:users|without_spaces|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
           'email' => 'required|email|min:3|max:25|unique:users',
           'password' => 'required|min:4|confirmed',
        ]);

        User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
        ]);

        auth()->attempt($request->only('name', 'email', 'password'));

        return redirect()->route('dashboard_index');
    }
}
