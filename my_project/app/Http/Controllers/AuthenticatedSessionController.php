<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    // Показываем страницу логина
    public function create()
    {
        return view('auth.login');
    }

    // Логика входа
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Проверяем email_verified_at
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user && !$user->email_verified_at) {
            return back()->withErrors([
                'email' => 'Сначала подтвердите email.',
            ])->withInput();
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/cabinet');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ])->withInput();
    }
    // Выход
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
