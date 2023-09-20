<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Route;
use App\Models\User;
use DB;
use App\Notifications\adminSendPasswordLink;
use Hash;

class AdminLoginController extends Controller
{
   
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }
    
    public function showLoginForm()
    {
      return view('admin.login');
    }
    
    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $request->email)->first();

        if ($user->hasRole('admin') || $user->hasRole('Sub Admin')) 
        {
            if (Hash::check($request->password, $user->password)) 
            {
                Auth::guard('admin')->login($user);
                return redirect()->intended(route('admin.dashboard'));
            }
            else
            {
                return back()->with('error','Invalid Login. If you’ve forgotten your password, please use the Forgot Password link.');
            }
        }
        else
        {
            return redirect()->back()->with('error','Sorry, there is no record of an account associated with this email. Please retry.')->withInput($request->only('email', 'remember'));
        }
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function forgetPassword(){
        return view('admin.forget-password');
    }

    public function sendForgetPasswordResetLink(Request $request){

        $request->validate(['email' => ['required', 'email']]);
        if ($user = User::where('email', $request->email)->roles()->where('name', '!=', 'admin')->first()) {

            $token = str_random(60);

            $password_reset_user = DB::table('password_resets')
                ->where('email', $request->email)
                ->first();

            if ($password_reset_user) {
                $token_saved = DB::table('password_resets')
                    ->where('email', $password_reset_user->email)
                    ->update([
                        'token' => $token]);

            } else {

                $token_saved = DB::table('password_resets')->insert(['email' => $request->email,
                    'token' => $token, 'created_at' => date('Y-m-d H:i:s')]);
            }


            if ($token_saved) {
                $user->notify(new adminSendPasswordLink($user,$token));
                return back()->with('success', 'Reset link is sent susscessfully, please check your mail.!');
            } else {
                return back()->with('error', 'This email does not exist.!');
            }


        } else {
            return back()->with('error', 'Sorry.!! this email id does not exist in our records.!');
        }
    }

    public function updateAdminForgotPassword(Request $request)
    {
        $this->validate($request, ['password' => 'required|confirmed|min:8', 'password_confirmation' => 'required']);

        $email = DB::table('password_resets')
            ->select('email')
            ->where('token', $request->token)
            ->first();

        $user = DB::table('users')
            ->select('*')
            ->where('email', $email->email)
            ->first();

        if ($request->password == $request->password_confirmation) {
            if ($user) {
                $password_updated = DB::table('users')
                    ->where('email', $user->email)
                    ->update(['password' => Hash::make($request->password)]);

                if ($password_updated) {
                    return redirect('/admin/login')->with(['password_updated' => 'Password is changed successfully.!']);
                } else {
                    return redirect('/admin/login')->with(['password_failure' => 'There is an error while changing the password please try again later.!']);
                }
            }
        } else {
            return redirect('/admin/login')->with('error', 'Password do not matched with confirm password.!');
        }
    }
}