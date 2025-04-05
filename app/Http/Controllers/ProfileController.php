<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        // Проверяем, существует ли профиль у пользователя
        if (!$user->profile) {
            // Создаем профиль для пользователя
            $user->profile()->create();
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
{
    $request->validate([
        'last_name' => 'nullable|string|max:255',
        'first_name' => 'nullable|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'street' => 'nullable|string|max:255',
        'house_number' => 'nullable|string|max:255',
        'apartment_number' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();

    // Проверяем, существует ли профиль у пользователя
    if (!$user->profile) {
        // Создаем профиль для пользователя
        $user->profile()->create();
    }

    $user->profile()->update($request->only([
        'last_name',
        'first_name',
        'middle_name',
        'country',
        'city',
        'street',
        'house_number',
        'apartment_number',
        'postal_code',
    ]));

    return redirect()->route('profile.edit')->with('success', 'Профиль обновлен!');
}
}