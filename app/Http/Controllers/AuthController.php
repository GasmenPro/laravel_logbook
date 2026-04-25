<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'employee_id' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('employee_id', $request->employee_id)
                    ->first();

        if ($user) {
            Session::put('user_id', $user->id);
            Session::put('user_role', $user->role);
            Session::put('user_name', $user->name);
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('employee.dashboard');
            }
        }

        return back()->with('error', 'Invalid credentials!');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}