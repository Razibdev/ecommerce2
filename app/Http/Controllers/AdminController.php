<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            if(Auth::attempt(['email' => $data["username"], 'password' => $data["password"], 'admin'=> 1])){
                return redirect('admin/dashboard');
            }else{
                return redirect('/admin')->with('flash_message_error','Invalid Username Or password');
            }
        }
        return view('admin.admin_login');
    }


   public function dashboard(){
        return view('admin.dashboard');
    }

    public function logout(){
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Logout successfully');
    }

    public function index(){
        return redirect('/' );
    }
}
