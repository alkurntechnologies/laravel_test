<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Session;
use DB;
use App\Notifications\sendPasswordLink;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
      return view('auth.login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required'
      ]);

      $user = User::where('email', $request->email)->first();
     
      if($user && ($user->roles()->where('name', '!=', 'admin') || $user->roles()->first() != null)) 
      {
              if($user->password != '')
              {
                  $remember_me = $request->has('remember_me') ? true : false;
                  if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $remember_me))
                  {
                    
                    Auth::login($user);
                    Auth::user()->save();

                    return redirect('/')->with('logged in successfully');
                  }
                  else{
                    return back()->with('error','Invalid Login Attempt. If you’ve forgotten your password, please use the Forgot Password link.');
                  }
              }else{
                return back()->with('error','Invalid Login Attempt. If you’ve forgotten your password, please use the Forgot Password link.');
              }
          }else
      {
        return redirect()->back()->with('error','Sorry, there is no record of an account associated with this email. Please retry.')->withInput($request->only('email', 'remember'));
      }
    }
    
    public function logout()
    {
        Auth::logout(); 

        return redirect('/login')->with('logged out successfully !');
    }

    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        if ($user = User::where('email', $request->email)->where('user_type','!=','admin')->first()) {
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
                $user->notify(new sendPasswordLink($user,$token));
                return back()->with('success', 'Please check your email for password reset instructions.');
            } else {
                return back()->with('error', 'This email does not exist.');
            }
        } else {
            return back()->with('error', 'This email does not exist.');
        }
    }

    public function updateForgotPassword(Request $request)
    {

        $validation = $this->validate($request, ['password' => 'required|min:8|confirmed', 'password_confirmation' => 'required']);
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
                    return redirect('/login')->with(['success' => 'Password was changed successfully.']);
                } else {
                    return redirect('/login')->with(['error' => 'There is an error while changing the password please try again later.!']);
                }
            }
        } else {
            return back()->with('error', 'Password do not matched with confirm password');
        }
    }

    public function addSellerFavorite(Request $request)
    {
        if(Auth::id() != $request->seller_id)
        {
            if($favorite = FavoriteProduct::whereUserId(Auth::id())->whereSellerId($request->seller_id)->first()){

                $msg = 'Seller is already added to your favorites !';
                $favorite = false;
            }else{

                FavoriteProduct::create([
                    'seller_id' => $request->seller_id,
                    'user_id' => Auth::id()
                ]);

                $msg = 'Seller add to favorites successfully !';
                $favorite = true;
            }
        }
    }

    public function addProductFavorite(Request $request)
    {
        if(! Product::whereId($request->product_id)->whereUserId(Auth::id())->first())
        {
            if($favorite = FavoriteProduct::whereUserId(Auth::id())->whereProductId($request->product_id)->first()){

                $msg = 'Product is already added to your favorites !';
                $favorite = false;
            }else{

                FavoriteProduct::create([
                    'product_id' => $request->product_id,
                    'user_id' => Auth::id()
                ]);

                $msg = 'Product add to favorites successfully !';
                $favorite = true;
            }
        }
    }

    
    public function addShipperFavorite(Request $request)
    {
        if(Auth::id() !== $request->shipper_id)
        {
            if($favorite = FavoriteShipper::whereUserId(Auth::id())->whereShipperId($request->shipper_id)->first()){

                $msg = 'shipper is already added to your favorites !';
                $favorite = false;
            }else{

                FavoriteShipper::create([
                    'shipper_id' => $request->shipper_id,
                    'user_id' => Auth::id()
                ]);

                $msg = 'shipper add to favorites successfully !';
                $favorite = true;
            }
        }

    }
}
