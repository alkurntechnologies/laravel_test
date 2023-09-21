@extends('front-user.layouts.master_user')

@section('content')

<section class="loginSection">
    <div class="logImgBox">
        <img class="position-absolute" loading="lazy" src="{{ asset('/') }}/assets/front-end/images/new-banner.jpeg" alt="">
    </div>
    <div class="container">
        <div class="logForm">
            <div class="instructionText">
                Fields marked with an <span class="color-red">*</span> are required
            </div>

            <div class="loginBox">
                <h3 class="section-header"><p>Login</p></h3>
                <div class="loginRight">
                    
                    <div class="authForm">
                        <form method="POST" autocomplete="off" enctype="multipart/form-data" data-parsley-trigger="blur" data-parsley-validate> 
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email address" name="email" required="" data-parsley-required-message="Please enter email." data-parsley-type-message="Please enter a valid email.">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                                <div class="forGotLink">
                                    <a href="{{url('forgot-password')}}">Forgot Password?</a>
                                </div>
                                <div class="password-field">
                                    <input type="password" class="password form-control" id="exampleInputPassword1" placeholder="Enter password" name="password" required="" data-parsley-required-message="Please enter password.">
                                    <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                                </div>
                                <!-- <span class="passChk">
                                    <input type="checkbox" id="checkPass"><label for="checkPass"></label>
                                </span> -->
                            </div>
                            <!-- <div class="form-group form-check custom-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember_me" checked="checked">
                                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                
                            </div> -->
                            <button type="submit" class="blueBtn">Sign in</button>
                        </form>
                    </div>
                    <p class="orText">OR</p>
                    <div class="cocialConnect d-flex justify-content-center">
                        <a href="{{url('login/facebook')}}"><img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/social_facebook.png" alt=""></a><br/>
                        <a href="{{url('login/google')}}"><img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/social_google.png" alt=""></a><br/>
                        <a href="{{url('login/linkedin')}}"><img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/social_linkedin.png" alt=""></a><br/>

                        
                        <!-- <a  class="facebook socialConectLink" data-href="{{url('login/facebook')}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/social_facebook.png" alt=""></a><br/>

                        <a  class="google socialConectLink" data-href="{{url('login/google')}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/social_google.png" alt=""></a><br/>

                        <a  class="linkedin socialConectLink" data-href="{{url('login/linkedin')}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/social_linkedin.png" alt=""></a><br/> -->
    
                    </div>
                    <div class="lbBtmTxt">Don't have an account? <a href="{{url('signup')}}">create one</a></div>
    

                    <!-- Modal -->
                    <div class="modal fade userTypePopup" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <!-- <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                </div> -->
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="select-userType">
                                        <div class="wizardHeading">Select User type</div>
                                        <div class="userType">
                                            <div class="customRadio">
                                                <input type="radio" name="user_type" value="buyer" id="buyer" required="" data-parsley-multiple="user_type"><label for="buyer">Buyer</label>
                                            </div>
                                            <div class="customRadio">
                                                <input type="radio" name="user_type" value="seller" id="seller" required="" data-parsley-multiple="user_type"><label for="seller">Seller</label>
                                            </div> 
                                            <div class="customRadio">
                                                <input type="radio" name="user_type" value="shipper" id="shipper" required="" data-parsley-multiple="user_type"><label for="shipper">Shipper</label>
                                            </div> 
                                            <span class="errorMsg"></span>
                                            <a href="" class="socialConectUrl" style="display: none">
                                                <input type="button" name="" value="Next">  
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section><!-- loginSection -->



@php 
if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],'password/reset')===false)
    Session::put('HTTP_REFERER',$_SERVER['HTTP_REFERER']);
@endphp

@endsection

@section('script_links')

@endsection

@section('script_codes')
<script type="text/javascript">  
    $("input[name='user_type']").change(function(){
        $('.socialConectUrl').show(); 
    });  

    $(".socialConectLink").click(function(){ 
        $('.socialConectUrl').attr("href", $(this).data("href"));
    });

    $(".socialConectUrl").click(function(){ 
        if($("input[name='user_type']:checked").val() == ''){
            $('.errorMsg').html('Please select user type');
        }else{
            $.ajax({
                type: "get",
                url: '{{ url("session-user-type") }}', 
                data: {'user_type': $("input[name='user_type']:checked").val() },
                success: function (data) { 
                    // alert($("input[name='user_type']:checked").val());
                }
            });
        } 
    });
</script>

@endsection