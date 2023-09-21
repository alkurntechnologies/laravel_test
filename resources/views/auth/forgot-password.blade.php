@extends('front-user.layouts.master_user')

@section('content')

<section class="loginSection">
    <div class="logImgBox">
        <img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/new-banner.jpeg" alt="">
    </div>
    <div class="container">
        <div class="logForm">
            <div class="instructionText">
                Fields marked with an <span class="color-red">*</span> are required
            </div>
            <div class="loginBox">
                <h3 class="section-header"><p>Forgot Password</p></h3>
                
                <div class="loginRight">
                    
                    <div class="authForm">
                        <label class="alksu">We will send a link to reset your password</label>
                        <form method="post" data-parsley-validate>
                            @csrf
                            <div class="form-group">
                                
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required="" data-parsley-required-message="Please enter email." data-parsley-type-message="Please enter a valid email.">
                            </div>
                            <button type="submit" class="blueBtn smallBtn">Forgot Password</button>
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
