<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index');

 
Route::post('/checkout', 'CartController@checkoutOne');

Route::get('/dashboard', 'UserController@dashboard');


Route::get('/product-list', 'HomeController@productList');

//login/register
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.submit');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/signup', 'Auth\RegisterController@showSignup')->name('signup');
Route::post('/signup', 'Auth\RegisterController@register')->name('register.submit');
Route::get('verify-user/{token}', 'Auth\RegisterController@verify_user');
Route::get('send-verification-mail/{email}','Auth\RegisterController@sendVerificationMail');

//forget password
Route::get('/forgot-password', function () {return view('auth.forgot-password');});
Route::post('/forgot-password', 'Auth\LoginController@forgetPassword');
Route::get('/password/reset/{token}', function ($token) {
    return view('auth.new-password')->with(['token' => $token]);
});
Route::post('/password/reset/{token}', 'Auth\LoginController@updateForgotPassword');

//social login
// Route::get('login/{provider?}', 'Auth\RegisterController@redirectToProvider');
// Route::get('callback/{provider}', 'Auth\RegisterController@handleProviderCallback');

Route::post('/add-to-cart', 'CartController@addToCart');
Route::post('/update-cart', 'CartController@updateCart');
Route::post('/remove-cart-product', 'CartController@removeProduct');

//after login

Route::middleware('auth')->group(function () {
        Route::get('checkout/{id?}','CartController@orderSummary');
        Route::post('checkout/{id?}','StripePaymentController@orderStore');
    
        Route::get('/notifications', 'UserController@notifications');
          
    Route::get('/change-password', function () {return view('front-user.common.change-password');});
    Route::post('/change-password', 'UserController@changePassword');

    Route::get('/my-profile', 'UserController@myProfile');
    Route::post('/my-profile', 'UserController@updateProfile');
});

//admin
Route::prefix('admin')->group(function() {
	Route::get('login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

      //Manage Roles
      Route::get('/manage-roles', 'AdminController@manageRoles')->name('roles.index')->middleware('can:Roles-view');
     
      Route::get('/edit-role/{id?}', 'AdminController@edit')->name('roles.edit')->middleware('can:Roles-edit');
      Route::post('/edit-role/{id?}', 'AdminController@update')->name('roles.update')->middleware('can:Roles-edit');
      Route::post('/delete-role', 'AdminController@destroy')->name('roles.destroy')->middleware('can:Roles-delete');

	//forget password routes
	Route::get('forget-password', 'Auth\AdminLoginController@forgetPassword');
	Route::post('send-forget-password-link', 'Auth\AdminLoginController@sendForgetPasswordResetLink');
	Route::get('password-reset/{token}', function ($token) {
	    return view('admin.reset-password')->with(['token' => $token]);
	});
	Route::post('update-forget-password', 'Auth\AdminLoginController@updateAdminForgotPassword');

	
	Route::get('/', 'AdminController@index')->name('admin.dashboard')->middleware('can:Users-view');;
	##Admin profile management Routes
    Route::get('/notifications', 'AdminController@notifications');
    Route::get('/profile', 'AdminController@profile')->name('admin.profile');
    Route::post('/update-admin-profile', 'AdminController@updateAdminProfile');
    Route::get('/change-password', 'AdminController@changePassword')->name('admin.change-password');
    Route::post('/update-admin-password', 'AdminController@updateAdminPassword');

    //Manage buyers
    Route::get('/manage-buyers', 'AdminController@manageBuyers')->middleware('can:Users-view');
 
    //Manage products
    Route::get('/manage-product-management', 'AdminController@manageProducts')->middleware('can:Products-view');
    Route::get('/add-product', 'AdminController@addProducts')->middleware('can:Products-create');
    Route::post('/add-product', 'AdminController@saveProducts')->middleware('can:Products-create');
    Route::get('/edit-product/{id?}', 'AdminController@editProduct')->middleware('can:Products-edit');
    Route::post('/edit-product/{id?}', 'AdminController@updateProduct')->middleware('can:Products-edit');
    Route::post('/delete-product', 'AdminController@deleteProduct')->middleware('can:Products-delete');

   
});

