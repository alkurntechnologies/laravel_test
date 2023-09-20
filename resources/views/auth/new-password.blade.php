@extends('front-user.layouts.master_user')

@section('content')
<section class="loginSection">
    <div class="container">
        <div class="logImgBox">
            <img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/auth_bg_imge.jpg" alt="">
        </div>
        <div class="logForm">
            <div class="loginBox">
                <h3>Set New Password</h3>
                <div class="loginRight">
                    
                    <div class="authForm">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                {{Session::get('success')}}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                {{Session::get('error')}}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                {{$errors->first()}}
                            </div>
                        @endif
                        <form method="post" data-parsley-validate>
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputPassword1">New Password  <span data-description="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="tootltip"><i class="fa-solid fa-question"></i></span></label>
                                <div class="password-field">
                                    <input type="password" class="password form-control" id="password" 
                                    placeholder="Password" name="password" required data-parsley-required-message="Please enter password."
                                    data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    data-parsley-pattern-message="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                    <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                                    <!-- <span class="passChk"><input type="checkbox" id="checkPass"><i class="far fa-eye-slash sd" style="display:none;"></i><i class="far fa-eye sd" ></i></span> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Re Enter New Password</label>
                                <div class="password-field">
                                    <input type="password" class="password form-control" id="exampleInputPassword1" placeholder="Re-enter password" name="password_confirmation" data-parsley-equalto="#password" data-parsley-equalto-message="Password and confirm password should be same." required data-parsley-required-message="Please re-enter password.">
                                    <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                                    <!-- <span class="passChk"><input type="checkbox" id="checkPass1"><i class="far fa-eye-slash sd1" style="display:none;"></i><i class="far fa-eye sd1"></i></span> -->
                                </div>
                            </div>
                            
                            <button type="submit" class="blueBtn smallBtn">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- loginSection -->

@endsection

@section('script_links')

@endsection

@section('script_codes')

@endsection
