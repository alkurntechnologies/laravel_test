@extends('front-user.layouts.master_user')
@section('title')
    {{config('app.name')}} | Not Found
@endsection

@section('content')
<main role="main">
    <section class="errorpage">
        <div class="container-fluid position-relative">
                <div class="row">
                    <div class="col-12 p-0">

    		          	<div class="col-sm-12 text-center">
    		            	<h1 class="authPageTitle"> Whoops We can't find the page you input!</h1>
    		            	<a class="btn btn-link" href="{{ url('/') }}">Go to Home</a>
    		            </div>
    		        </div>
            </div>
        </div>
    </section>
</main>

@endsection