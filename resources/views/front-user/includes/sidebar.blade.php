<!-- <div class="sidebarSearch">
  <input type="text" placeholder="Search">
  <button>
  <i class="fa-solid fa-magnifying-glass"></i>
  </button>
</div> -->
<ul>
	<li><a href="{{url('dashboard')}}" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
	<li><a href="{{url('notifications')}}" class="{{ Request::is('notifications') ? 'active' : '' }}"><i class="bi bi-bell"></i> Notifications</a></li>
	<li><a href="{{url('my-profile')}}" class="{{ Request::is('my-profile') ? 'active' : '' }}"><i class="bi bi-person"></i> Profile</a></li>
	<li><a href="{{url('change-password')}}" class="{{ Request::is('change-password') ? 'active' : '' }}"><i class="bi bi-key"></i> Change Password</a></li>
  	<li><a href="{{url('logout')}}"><i class="bi bi-box-arrow-left"></i> Sign Out</a></li>
</ul>

<script>
jQuery(document).ready(function(){
	jQuery(".dashMenu").click(function(){
		jQuery(".side-profile").toggleClass("expand");
  });
});
// jQuery(".hasChild").click(function(){
// 	jQuery(this).toggleClass("activeSubmenu");
// 	jQuery(".childMenu").removeClass("activeChild");
// 	jQuery(this).find(".childMenu").addClass("activeChild");
// })

$('.hasChild').click(function() {
 	var subMenu = $(this).attr('class').substring(-1,7);
 	
	$(".childMenu").slideUp('active');
 	if ( !$( this ).hasClass( 'active' ) ) {
		$(".hasChild").removeClass('active');
 			$(this).find(".childMenu").slideDown('active');
			 $(this).addClass('active');
			 return false;
 	}else{
		$(this).removeClass('active');
	}
	// $(this).find(".childMenu").hide('active');
	// $(this).toggleClass('active');
});

</script>