<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>


    </ul>



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->




        @if (Route::has('admin.login'))
            <div class="top-right links">
                @auth

                    {{--<a href="{{ route('admin.logout') }}">Logout</a>--}}

                    @php $notification = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->where('read_at', NULL)->count(); @endphp
                    <li class="notification">
                        <a href="{{URL::to('admin/notifications')}}">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <span>{{$notification}}</span>
                        </a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">

                        Welcome <strong>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</strong>


                    </li>

                    <li class="nav-item d-none d-sm-inline-block"><a href="#"></a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="{{ route('admin.profile') }}" class="nav-link">   <i class="fas fa-id-badge"></i> Profile</a>
                            </li>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="{{ route('admin.change-password') }}" class="nav-link">   <i class="fas fa-lock"></i> Change Password</a>
                            </li>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="{{ route('admin.logout') }}" class="nav-link">   <i class="fas fa-power-off"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <a href="{{ route('admin.login') }}">Login</a>
                @endauth
            </div>
        @endif
    </ul>
</nav>
<!-- /.navbar -->