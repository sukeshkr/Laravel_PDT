<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return auth()->user();
        return view('user.users');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('sucess','Sucessfully Logged out');
    }
    public function userList()
    {
        $users = User::paginate(2);
        return view('master.user-list',compact('users'));
    }
}
