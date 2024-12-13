<?php

namespace App\Http\Controllers;

use App\Models\IPAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function do_login(Request $request){
        if(!$request->email || !$request->password){
            return redirect()->back()->withInput()->with('error', 'These credentials do not match our records.');
        }
        $user = User::where('email', $request->email)->where('status', 1)->first();
        if(!$user){
            return redirect()->back()->withInput()->with('error', 'These credentials do not match our records.');
        }
        $remember = $request->remember ? true : false;
        if(!Auth::attempt($request->only(['email', 'password']), $remember)){
            return redirect()->back()->withInput()->with('error', 'These credentials do not match our records.');
        }
        return redirect()->route('home')->with('success', 'Welcome back ' . $user->username . ' !');
    }

    public function allow_nsfw(){
        $ip = $this->get_client_ip();

        $access = IPAccess::where('ip', $ip)->first();
        if(!$access){
            $access = new IPAccess();
            $access->ip = $ip;
        }
        $access->nsfw = true;
        $access->save();
        return redirect()->back();
    }
}
