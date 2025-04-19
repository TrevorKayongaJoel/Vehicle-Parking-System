<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        
        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,attendant',
        ]);
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
                'role' => $request->role,
            ]);
            \Log::info('Updating user role', [
                'id' => $user->id,
                'new_role' => $request->role
            ]);;
    
        return redirect()->route('admin.users')->with('status', 'User updated successfully!');
    }
    
}
