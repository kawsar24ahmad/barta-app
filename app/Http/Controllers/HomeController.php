<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()  {
        return view('admin.dashboard');
    }
    public function profile() {
       
        return view('admin.profile');
    }
    public function editProfile(Request $request) {
         
        if ($request->isMethod('PUT')) {
            $userId = auth()->user()->id;
            $validated = $request->validate([
                'name'=> 'required|string',
                'email' => 'required|email|unique:users,email,' . $userId,
                'password'=> 'nullable|min:8',
                'bio'=> 'required',
            ]);

            $updateData = [
                'name'=> $request->name,
                'email'=> $request->email,
                'bio'=> $request->bio,
            ];
            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }
            $updatedUser = DB::table('users')
            ->where('id', $userId)
            ->update($updateData);

           

            if ($updatedUser) {
                return to_route('profile')->with('success', 'Update is Successful!');
            }
            return back()->with('error', 'Update is not Successful!');
        }
        return view('admin.edit-profile');
    }
}
