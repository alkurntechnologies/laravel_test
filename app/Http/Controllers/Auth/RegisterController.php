<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Storage;  
use File;
use DB;
use Mail;
use GuzzleHttp\Client;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'], 
            'name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[
            'email.unique'=>'The email is already registered on this site.',
            'password.confirmed'=>'The proposed passwords do not match.',
        ]);
    }

    protected function register(Request $request)
    {
        $formData = request()->except(['_token']); 
       
        // validate the user form data
        $validation = $this->validator($formData);
        
        // if validation fails
        if ($validation->fails()) {
            // redirect back to the form 
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // if validation passes
        $password = $formData['password'];
        $formData['password'] = Hash::make($formData['password']);

        unset($formData['password_confirmation']);
        // save the user to the database
        $user = User::create($formData);

         // return a view 
        return redirect('/login')->with('success', 'Registration successful!');
    }

   }
