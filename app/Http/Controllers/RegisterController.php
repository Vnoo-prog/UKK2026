<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|',
            'kelas' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'role' => 'siswa',
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('login')->with('success', 'regis berhasil, silahkan login!');
    }
}