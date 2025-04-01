<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function showLoginForm(){
        return view('chatbotai.login.login');
    }

    // public function demo(){
    //     return view('chatbotai.demo');
    // }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return view('chatbotai.login.login-success');
            // return redirect()->intended('/chatbotai.login.login-success'); // chuyển đến dashboard
        }else{
            return back()->withErrors([
                'login_failed' => 'Tài khoản hoặc mật khẩu không đúng.',
            ]);
        }
    }

    //
    public function showRegistrationForm(){
        return view('chatbotai.login.register'); // Đảm bảo view 'chatbotai.login' tồn tại
    }

    //  Method register ||  Phương thức đăng ký
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password1' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo tài khoản
        User::create([
            'username' => $request->username,
            'email' => $request->email, 
            'password' => $request->password1,
        ]);

        return view('chatbotai.login.register-success');
    }

    public function demo(){
        return view('chatbotai.login.demo'); // Đảm bảo view 'chatbotai.login' tồn tại
    }
}
