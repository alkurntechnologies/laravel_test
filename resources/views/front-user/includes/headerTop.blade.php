<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=62e3f6f701f23300194c70f3&product=inline-share-buttons" async="async"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <meta name="twitter:card" content="summary_large_image">
    
        <title>{{config('app.name')}}</title>
    

   

    <!-- <link rel="icon" type="image/png" sizes="45x45" href="{{ asset('/') }}assets/frontend/images/logo.png"> -->

    {{-- <link rel="shortcut icon" href="{{ asset('/') }}assets/front-end/images/favicon.ico" type="image/x-icon">

    <link rel="shortcode icon" type="image/png" href="{{ asset('/') }}assets/front-end/images/logo.png"/> --}}
    <link rel="icon" type="image/png" href="{{ asset('/assets/front-end/images/favicon/apple-icon-57x57.png') }}" >
    {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/front-end/images/favicon/apple-icon-57x57.png') }}"> --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/assets/front-end/images/favicon/apple-icon-57x57.png') }}" >
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('/assets/front-end/images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/assets/front-end/images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/assets/front-end/images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/assets/front-end/images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/assets/front-end/images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/assets/front-end/images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/assets/front-end/images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/assets/front-end/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('/assets/front-end/images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/front-end/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/assets/front-end/images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/front-end/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/assets/front-end/images/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('/assets/front-end/images/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Scripts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <link href="{{ asset('/') }}assets/front-end/css/jquery.dataTables.min.css" rel="stylesheet" media="all" defer>
    <!-- Vendor CSS Files -->
    <link href="{{ asset('/') }}assets/front-end/css/aos/aos.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/glightbox/css/glightbox.min.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/remixicon/remixicon.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/swiper/swiper-bundle.min.css" rel="stylesheet" media="all" defer>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" media="all" defer />

    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/front-end/css/uicons-solid-rounded.css" media="all" defer />
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/front-end/css/uicons-regular-rounded.css" media="all" defer />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" media="all" defer />

    <!-- Template Main CSS File -->
    <link href="{{ asset('/') }}assets/front-end/css/style_new.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/normalize.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/bootstrap-icons.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/responsive.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/bootstrap-datepicker.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/parsley.css" rel="stylesheet" media="all" defer>
    <link href="{{ asset('/') }}assets/front-end/css/parsley.css" rel="stylesheet" media="all" defer>

    <link href="{{asset('/assets/admin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" media="all" defer/>
    <!-- <link rel="stylesheet" href="{{ asset('/') }}assets/front-end/css/toasteur-default.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    

    <script src="{{ asset('/') }}assets/front-end/js/parsley.min.js"></script>
    <!-- New calender -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/front-end/css/pignose.calendar.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" media="all" defer>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163116032-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-163116032-1');
    </script>  

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MMN7DVB');</script>
    <!-- End Google Tag Manager -->
    @yield('style')
</head>

@if(Auth::check())
<body class="{{Request::segment(1)}}-layout logedin">
@else
<body class="{{Request::segment(1)}}-layout">  
@endif
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MMN7DVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- <body class="{{Request::segment(1)}}-layout "> -->