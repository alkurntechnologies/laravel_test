<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} | Forget Password</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('/assets/admin/plugins/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/admin/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>

        .alert-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: .75rem 1.25rem;
            color: inherit;
            outline: none !important;
            margin: -3px 0 0 0;
        }

        .parsley-errors-list {
            list-style:none!important;
            color:red!important;
            padding: 0;
            margin: 0;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
        }

        .parsley-errors-list li {
            padding: 0;
            margin: 0 0 0 0;
        }

        .parsley-custom-error-message {
            color: red;
            
            list-style: none;
        }

        .parsley-required{
            color: red;
            font-family:"rubiklight";
            list-style: none;
        }

        .parsley-errors-list.filled .parsley-type {
            color: red;
  
            list-style: none;
        }

        .parsley-errors-list.filled .parsley-required {
            color: red;
        
            white-space: nowrap;
            list-style: none;
        }
        
        .parsley-errors-list.filled .parsley-length{
            color: red;
         
            list-style: none;
        }
    </style>

</head>
<body class="hold-transition login-page" style="background:url({{ URL::asset('/') }}/images/Background.png), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5));
background-blend-mode: overlay;
 background-size:cover; background-repeat:no-repeat;">
<div class="login-box">
    <div class="login-logo">

        <a ><b>{{config('app.name')}}</b> Admin</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Please enter new password</p>

            <div class="">
                <a class="hiddenanchor" id="toregister"></a>
                <a class="hiddenanchor" id="tologin"></a>

                <div id="wrapper">
                    <div id="login" class=" form"> 
                        <section class="login_content">
                            <form method="POST" action="{{  URL::to('/admin/update-forget-password') }}"  autocomplete="off" data-parsley-validate>
                                @csrf
                                
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                      <ul>
                                        <li>{{ $errors->first() }}</li>
                                      </ul>
                                    </div>
                                @endif

                                <input type="hidden" name="token" value="{{ $token }}">


                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Enter password" required data-parsley-required-message="Please enter new password.">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Enter confirm password" required data-parsley-required-message="Please enter confirm password.">
                                </div>


                                <div class="form-group">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center">

                                {{--<p>Copyrights &copy; {{date('Y')}} All Rights Reserved.</br> Powered by <a href="http://www.alkurn.com" target="_blank">Alkurn</a></p>--}}
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<script src="{{asset('/assets/admin/js/jquery.min.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html>







