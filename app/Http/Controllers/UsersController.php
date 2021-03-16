<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Country;
use Auth;
use Session;
class UsersController extends Controller
{
    public function userLoginRegister(){
        return view('wayshop.users.login_register');
    }

    public function register(Request $request){
        if($request->isMethod('POST')){
            $data = $request->all();
            $userCount = User::where('email', $data['email'])->count();
            if($userCount > 0){
                return redirect()->back()->with('flash_message_error', 'Email is already Exist');
            }else{
                // Adding user in table

                $user = new User;
                $user->name = $data["name"];
                $user->email = $data["email"];
                $user->password = bcrypt($data["password"]);
                $user->save();
                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    Session::put('frontSession', $data['email']);
                    return redirect('/cart');
                }
            }
        }
    }

    public function logout(){
        Session::forget('frontSession');
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function login(Request $request){
        if($request->isMethod('POST')){
            $data = $request->all();
            if(Auth::attempt(['email'=> $data['email'], 'password' => $data["password"]])){
                Session::put('frontSession', $data['email']);
                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error', 'Invalid username or password');
            }
        }
    }

    public function account(Request $request){
        return view('wayshop.users.account');
    }

    public function changePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $old_pwd = User::where('id', Auth::User()->id)->first();
            $current_password = $data["current_password"];
            if(Hash::check($current_password, $old_pwd->password)){
                $new_pwd = bcrypt($data['new_password']);
                User::where('id',Auth::User()->id)->update(['password'=> $new_pwd]);
                return redirect()->back()->with('flash_message_success', 'Your Password is change now!');

            }else{
                return redirect()->back()->with('flash_message_error', 'Old Password is incorrect !');
            }

        }
        return view('wayshop.users.change_password');
    }

    public function changeAddress(Request $request){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        if($request->isMethod('post')){
            $data = $request->all();
            $users = User::find($user_id);
            $users->name = $data["name"];
            $users->address = $data["address"];
            $users->state = $data["state"];
            $users->city = $data["city"];
            $users->country = $data["country"];
            $users->pincode = $data["pincode"];
            $users->mobile = $data["mobile"];
            $users->save();
            return redirect()->back()->with('flash_message_success', 'Account Details has been updated');

        }
        $countries = Country::get();
        return view('wayshop.users.change_address')->with(compact('countries', 'userDetails'));
    }
}
