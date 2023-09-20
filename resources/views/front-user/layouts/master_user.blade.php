@include('front-user.includes.header')
<div class="contentPages">
    @include('front-user.includes.flash-message')

    @yield('content')

    <!-- Home page middle Section end -->
</div>
@include('front-user.includes.footer')
@yield('script_links')
@yield('script_codes')
</body>
</html>

    <!-- Middlecontent end -->
