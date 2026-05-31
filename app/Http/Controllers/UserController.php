<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $r)
    {
        $validation = Validator::make($r->all(), [
            'name' => 'required|string',
            'surname' => 'required|string',
            'patronymic' => 'string',
            'login' => 'required|string|unique:App\Models\User,login',
            'email' => 'required|string|email:rfc|unique:App\Models\User,email',
            'password' => 'required|string|min:6',
            'password_repeat' => 'required|string|same:password',
            'rules' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        User::create([
            'name' => $r->name,
            'surname' => $r->surname,
            'patronymic' => $r->patronymic,
            'login' => $r->login,
            'email' => $r->email,
            'password' => Hash::make($r->password),
        ]);
        return response()->json(['register' => 'success1'], 200);
    }
    public function auth(Request $r)
    {
        $validation = Validator::make($r->all(), [

            'login' => 'required|string',
            'password' => 'required|string|',

        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        if (Auth::attempt([
            'login' => $r->login,
            'password' => $r->password
        ])) {
            if (Auth::user()->is_admin == 1) {
                return response()->json(['admin' => 'success1'], 200);
            } else {
                return response()->json(['auth' => 'success1'], 200);
            }
        } else {
            return response()->json(['login' => '', 'password' => 'Неверный логин или пароль'], 400);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
