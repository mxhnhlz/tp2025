<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\PendingUser;
use Illuminate\Support\Facades\Mail;



class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email|unique:pending_users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $token = Str::random(64);

        $pendingUser = PendingUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token' => $token,
        ]);

        // Отправляем письмо
        Mail::to($pendingUser->email)->send(new \App\Mail\VerifyEmail($pendingUser));

        return redirect()->route('login')->with('success', 'Проверьте ваш email для подтверждения регистрации');
    }

    public function verifyEmail($token)
    {
        $pendingUser = PendingUser::where('token', $token)->firstOrFail();

        // Создаём пользователя в основной таблице
        $user = \App\Models\User::create([
            'name' => $pendingUser->name,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password,
            'email_verified_at' => now(), // ← помечаем email как подтверждённый
        ]);

        // Удаляем из pending
        $pendingUser->delete();

        Auth::login($user);

        return redirect('/sections')->with('success', 'Регистрация подтверждена! Добро пожаловать.');
    }


}
