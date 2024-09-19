<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class AuthController extends Controller
{
    public function register(Request $request)  {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|string',
                'username' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
           $user =  DB::table('users')->insert([
                'name' =>       $request->name,
                'username' =>   $request->username,
                'email' =>      $request->email,
                'password' =>  bcrypt( $request->password),
            ]);

            if ($user) {
                return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
            } else {
                return back()->with('error', 'Registration failed. Please try again.');
            }
        }
        return view('auth.register');
    }
    public function login(Request $request)  {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'email'=> 'required|email',
                'password'=> 'string|min:8'
            ]);
            $creditials = $request->only('email', 'password');
            // dd($creditial);
            if (Auth::attempt($creditials)) {
                return redirect()->route('dashboard')->with('success', 'Login Successful!');
            }

            return back()->with('error', 'Login not successful!');
        
        }
        
        return view('auth.login');
    }
    
    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout is Successfull!');
    }
    
}
