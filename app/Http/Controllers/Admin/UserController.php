<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->role || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (!Auth::check() || !Auth::user()->role || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::check() || !Auth::user()->role || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id'],
            ['role_id.required' => 'Необходимо выбрать роль.',
             'role_id.exists' => 'Выбранная роль не существует.'
            ]);

        $user->update(['role_id' => $request->role_id]);

        return redirect()->route('users.index');
    }
}