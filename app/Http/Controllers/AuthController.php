<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $role = Role::where('name', 'user')->first();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);


        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],[

        'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.min' => 'Имя должно содержать минимум 3 символа.',
            'email.required' => 'Введите ваш email.',
            'email.email' => 'Введите корректный email-адрес.',
            'email.unique' => 'Этот email уже зарегистрирован.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 6 симво-лов.',
            'password.confirmed' => 'Пароли не совпадают.']);

        if (Auth::attempt($credentials)) {
            // Аутентификация прошла успешно

            // Получаем ID сессии текущего пользователя
            $session_id = session()->getId();

            // Получаем email пользователя
            $user_email = Auth::user()->email;

            // Получаем guestSessionId из cookie
            $guestSessionId = $_COOKIE['guestSessionId'] ?? null;

            // Проверяем, изменился ли session_id
            if ($guestSessionId && $session_id !== $guestSessionId) {
                // Сессия изменилась!

                // Обновляем user_email для всех товаров в корзине с данным session_id
                DB::table('carts')
                    ->where('session_id', $guestSessionId) // Используем guestSessionId
                    ->update(['user_email' => $user_email, 'session_id' => null]);

                // Обновляем user_email для всех товаров в корзине с user_email = NULL
                DB::table('carts')
                    ->where('user_email', NULL)
                    ->where('session_id', $guestSessionId) // Используем guestSessionId
                    ->update(['user_email' => $user_email, 'session_id' => null]);
            }

            // Перенаправляем пользователя
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Неверный логин или пароль.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}