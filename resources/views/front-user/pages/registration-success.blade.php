@extends('front-user.layouts.master_user')

@section('content')

<section class="cartPage">
    <div class="container">
        <div class="text-center placeorder">
            <div class="placeorderTitle">
                Welcome to E-Railspot
            </div>
            <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/celebration.jpg" class="img-fluid" alt="">
            <div class="ordertext">Dear {{$user->first_name}} {{$user->last_name}}, Thank you for registering with <a href="{{url('/')}}">E-Railspot</a>.  </div>
            <div class="ordertext">Please check your email({{$user->email}}) for verification. </div>
        </div>
    </div>
</section>


@endsection

@section('script_links')


@endsection

@section('script_codes')

@endsection