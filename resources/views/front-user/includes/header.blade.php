@include("front-user.includes.headerTop")

<!-- ======= Header ======= -->
<header id="header" class="header">
  
    <div class="container d-flex align-items-center justify-content-between">
      <a href="{{url('/')}}" class="logo d-flex align-items-center">
        <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/logo-white.png" alt="">
      </a>
      {{-- <div class="tagTopline">
        BUY. SELL. SHIP.
      </div> --}}
      <div class="menu-overlay"></div>
      
      <nav class="navbar ms-auto">
        <ul id="navbar">
          <li><a class="nav-link scrollto {{url('')==url()->current()?'active':''}}" href="{{url('')}}">Home</a></li>
          @if(!Auth::check())
          <li class="p-0">
            <a href="{{url('signup')}}" class="signupbtn {{url('')==url()->current()?'active':''}}">
              <svg class="svg-inline--fa fa-user-plus fa-xl" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg=""><g class="fa-duotone-group"><path class="fa-secondary" fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path><path class="fa-primary" fill="currentColor" d="M616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"></path></g></svg>  <span class="mntxt">Sign Up</span>

            </a>
          </li>
          <li class="p-0"><a class="signin_link nav-link scrollto {{url('login')==url()->current()?'active':''}}" href="{{url('login')}}"><svg class="svg-inline--fa fa-lock-keyhole" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="lock-keyhole" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><g class="fa-duotone-group"><path class="fa-secondary" fill="currentColor" d="M224 64C179.8 64 144 99.82 144 144V192H80V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H304V144C304 99.82 268.2 64 224 64z"></path><path class="fa-primary" fill="currentColor" d="M384 192C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H384zM256 320C256 302.3 241.7 288 224 288C206.3 288 192 302.3 192 320V384C192 401.7 206.3 416 224 416C241.7 416 256 401.7 256 384V320z"></path></g></svg> <span class="mntxt">Login</span></a></li>
          
          @else 
          |<li><a class="nav-link scrollto {{url('product-list')==url()->current()?'active':''}}" href="{{url('product-list')}}">Product List</a></li>

          @endif
        </ul>
        @if(Auth::check())
        @php 
            $notification = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->where('read_at', NULL)->count();
            $cartCount = 0;
            if(Auth::check()){
              $cartCount = App\Models\CartDetail::whereUserId(Auth::id())->count();
            }          
        @endphp

        <ul class="d-flex mainmblMenu m-0">
          <li><a class="nav-link scrollto {{url('notifications')==url()->current()?'active':''}}" href="{{url('notifications')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-title="Notifications"><i class="fi fi-rr-bell"></i><span class="hrCnt">{{$notification}}</span></a></li>
          <li><a class="nav-link scrollto {{url('checkout')==url()->current()?'active':''}}" href="{{url('checkout')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-title="Cart"><i class="fi fi-rr-shopping-cart"></i><span id="cartCount" class="hrCnt">{{$cartCount}}</span></a></li>

        @endif
      
        @if(Auth::check())
          <li class="d-md-none">
            <div class="SearchMobileIcon">
              <i class="fi fi-rr-search"></i>
            </div>
          </li>
        </ul>
        @endif
      </nav><!-- .navbar -->
      @if(Auth::check())
        <li class="dropdown">
          <button class="headerToggle" type="button" id="mymenu" >
            <img loading="lazy" src="{{ URL::to('storage/app')."/".Auth::user()->profile_pic}}"
            onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/userImage1.jpg'"  alt="">
          </button>
          <ul class="dropdown-menu customDropdown">
            <span class="d-block d-xl-none">
              <li><a href="{{url('dashboard')}}" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
              <li><a href="{{url('orders')}}" class="{{ Request::is('orders') ? 'active' : '' }}"><i class="bi bi-archive"></i> Orders</a></li>
              <li><a href="{{url('products-management')}}" class="{{ Request::is('products-management') ? 'active' : '' }}"><i class="bi bi-archive"></i> Products Management</a></li>
              <li><a href="{{url('notifications')}}" class="{{ Request::is('notifications') ? 'active' : '' }}"><i class="bi bi-bell"></i> Notifications</a></li>
              <li><a href="{{url('my-profile')}}" class="{{ Request::is('my-profile') ? 'active' : '' }}"><i class="bi bi-person"></i> Profile</a></li>
              <li><a href="{{url('change-password')}}" class="{{ Request::is('change-password') ? 'active' : '' }}"><i class="bi bi-key"></i> Change Password</a></li>
              <li><a href="{{url('logout')}}"><i class="bi bi-box-arrow-left"></i> Sign Out</a></li>
            </span>
            <span class="d-none d-xl-block">
              <li><a class="dropdown-item" href="{{url('dashboard')}}">Dashboard</a></li>
              <li><a class="dropdown-item" href="{{url('my-profile')}}">Profile</a></li>
              <li><a class="dropdown-item" href="{{url('change-password')}}">Change password</a></li> 
              <li><a class="dropdown-item" href="{{url('logout')}}">Logout</a></li>
            </span>
          </ul>
        </li>
      @endif
    <i class="bi bi-list mobile-nav-toggle"></i>
</header><!-- End Header -->
<script>
  // jQuery(".hasChild").click(function(){
  //   jQuery(this).toggleClass("activeSubmenu");
  //   jQuery(".childMenu").removeClass("activeChild");
  //   jQuery(this).find(".childMenu").addClass("activeChild");
  // })

  $('.hasChild').click(function() {
 	var subMenu = $(this).attr('class').substring(-1,7);
 	$(".childMenu").removeClass('active');
 	if ( !$( this ).hasClass( 'active' ) ) {
 			$(this).find(".childMenu").addClass('active');
 	}
	// $(this).find(".childMenu").removeClass('active');
	$(this).toggleClass('active');
});

  // $(document).ready(function(e) {
  //     $("#mymenu").click(function(event) {
  //         $(".customDropdown").addClass("mobile-open");
  //         event.stopPropagation();
  //     });

  //     $(document).click(function(event){
  //         if (!$(event.target).hasClass('customDropdown')) {
  //             $(".customDropdown").removeClass("mobile-open");
  //         }
  //     });
  // });

  const $menu = $('.customDropdown')

const onMouseUp = e => {
 if (!$menu.is(e.target) // If the target of the click isn't the container...
   && $menu.has(e.target).length === 0) // ... or a descendant of the container.
   {
     $menu.removeClass('mobile-open')
  }
}

$('#mymenu').on('click', () => {
  $menu.toggleClass('mobile-open').promise().done(() => {
    if ($menu.hasClass('mobile-open')) {
      $(document).on('mouseup', onMouseUp) // Only listen for mouseup when menu is active...
    } else {
      $(document).off('mouseup', onMouseUp) // else remove listener.
    }
  })
})

</script>