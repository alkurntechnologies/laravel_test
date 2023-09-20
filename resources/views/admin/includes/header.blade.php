<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page_title')</title>

    <!-- Fonts -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{URL::asset('/assets/admin/css/bootstrap.min.css')}}">
    <link href="{{asset('/assets/admin/css/adminlte.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/admin/css/admin-custom.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/admin/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/front-end/css/uicons-solid-rounded.css" media="all" defer />
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/front-end/css/uicons-regular-rounded.css" media="all" defer />
    <link href="{{asset('/assets/admin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('/assets/admin/plugins/toastr/toastr.min.css') }}" rel="stylesheet"/>
  
    <link rel="stylesheet" href="{{asset('/assets/admin/css/jquery.filer.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/front-end/css/pignose.calendar.min.css" />
    <link href="{{ asset('/') }}assets/front-end/css/swiper/swiper-bundle.min.css" rel="stylesheet" media="all" defer>
    <style>
    
    .alert-dismissible .close {
        position: absolute;
        top: 0;
        right: 0;
        padding: .75rem 1.25rem;
        color: inherit;
        outline: none!important;
    }
    </style>


    <script src="{{asset('/assets/admin/js/jquery.min.js')}}"></script>


    @yield('admin_styles_links')
    @yield('admin_styles_code')


    <!-- Styles -->

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
