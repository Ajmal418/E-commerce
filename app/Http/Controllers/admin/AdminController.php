<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {       

        $user=[
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin@123')
        ];
        // User::create($user);
        return view('admin.login');
    }

    public function login(Request $request)
    {
       $validation= $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::guard('web')->attempt(['email'=>$request->email,'password'=>$request->password])) {     

            return redirect()->route('admin.dashboard'); 
            
        }else{
            return redirect()->route('admin.login')->with('status', 'User authentication is failed');
        }
    }
    

    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }



}
