<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    //
    public function index(){
        return view('login');
    }

    public function login(Request $req){
        $data = [
            'username' => $req->username,
            'password' => $req->password
        ];

        if(Auth::attempt($data)){
            if(Auth::user()->role === 'admin'){
                return redirect()->route('dashboard.admin');
            }
            else if(Auth::user()->role === 'dokter'){
                return redirect()->route('dashboard.dokter');
            }
        }else {
            return redirect()->route('login')->with('failed', 'Username atau Password salah');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->to('/login');
    }
}
