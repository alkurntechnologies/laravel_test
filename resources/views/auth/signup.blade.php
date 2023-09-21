@extends('front-user.layouts.master_user')

@section('content')
<section class="loginSection">
    <div class="logImgBox">
        <img loading="lazy" class="position-absolute" src="{{ asset('/') }}/assets/front-end/images/new-banner.jpeg" alt="">
    </div>
    <div class="container">
        <div class="logForm registrationForm">
            <div class="instructionText">
                Fields marked with an <span class="color-red">*</span> are required
            </div>
            <div class="loginBox mt-5">
                {{-- <h3>Sign up</h3> --}}
                <div class="loginRight">  
                                         
                    <div class="authForm">
                            <form method="POST" autocomplete="off" action="{{ route('register.submit') }}" enctype="multipart/form-data" data-parsley-trigger="blur" data-parsley-validate>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="name_buyer"> Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name_buyer" aria-describedby="emailHelp" placeholder="Enter Name" name="name" required="" data-parsley-required-message="Please enter Name." value="{{old('name')}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email1_buyer">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email1_buyer" aria-describedby="emailHelp" placeholder="Enter email" name="email" required=""  data-parsley-required-message="Please enter email."data-parsley-type-message="Please enter a valid email." value="@if (!$errors->has('email')){{old('email')}}@endif" >
                                        </div>
                                    </div>

                                <div class="row">
                                    
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="password2">Password <span class="text-danger">*</span>
                                                <span data-description="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="tootltip"><i class="fa-solid fa-question"></i></span>
                                            </label>
                                            <div class="password-field">
                                                <input type="password" class="password form-control" id="password" placeholder="Password"
                                                name="password" required data-parsley-required-message="Please enter password." 
                                                value="@if (!$errors->has('password')){{old('password')}}@endif"
                                                data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                data-parsley-pattern-message="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                                <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                                                <!-- <span class="passChk"><input type="checkbox" id="checkPass"><label for="checkPass"></label></span> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="reEnterPassword2">Re Enter Password <span class="text-danger">*</span></label>
                                            <div class="password-field">
                                                <input type="password" class="password form-control" id="reEnterPassword2" name="password_confirmation" data-parsley-equalto="#password" data-parsley-equalto-message="Password and confirm password should be same." required data-parsley-required-message="Re enter password." placeholder="Re enter password" value="@if (!$errors->has('password_confirmation')){{old('password_confirmation')}}@endif">

                                                <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" class="blueBtn smallBtn" value="Sign up">Sign up</button>
                                        </div>
                                    </div>
                                </div> 
                            </form>
                        </div>
                        <div class="lbBtmTxt mt-4">Already Registered? <a href="{{url('login')}}">Sign in</a></div>
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
<script type="text/javascript">

</script>

@endsection