@include('admin.includes.header')

@include('admin.includes.navbar')
@include('admin.includes.flash-message')

@include('admin.includes.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        @yield('content')
</div>
@include('admin.includes.footer')