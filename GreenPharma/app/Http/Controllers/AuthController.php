<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthController extends Controller
{
    public function dashboard(){
        if(Auth::check() === true){
            return view('dashboard');
        }
        return redirect()->route('login');
    }
    public function import(){
        if(Auth::check() === true && session('tipo') == 1){
            return view('import');
        }
        return redirect()->route('login');
    }
    public function report(){
        if(Auth::check() === true){
            return view('report');
        }
        return redirect()->route('login');
    }
    public function showLoginForm(){
        return view('login');
    }
    public function login(Request $request){

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            $user = Auth::user()->name;
            $tipo = Auth::user()->flg_type;
            $request->session()->put(['user' => $user , 'tipo' => $tipo]);
            return redirect()->route('admin');
        }else{
            $request->session()->forget(['user','tipo']);
            return redirect()->back()->withInput()->withErrors(['Os dados digitados não conferem!']);
        }

    }
    public function logout(){
        session()->forget(['user','tipo']);
        Auth::logout();
        return redirect()->route('admin');
    }
}
