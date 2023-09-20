@include('front-user.includes.header')
<div class="dashboard">
    
    <div class="dashboard-page-content">
        <div class="side-profile">
        @include('front-user.includes.sidebar')
        </div><!-- blogListing -->
        <div class="dashboard-page-scroll-content">
            @include('front-user.includes.flash-message')
        
            @yield('content')
            
            <!-- Home page middle Section end -->
            
            
            @include('front-user.includes.footer')
        </div>
    </div>
    
   
    @yield('script_links')
    @yield('script_codes')
</div>
</body>
</html>

    <!-- Middlecontent end -->
