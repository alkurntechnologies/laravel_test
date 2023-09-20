@extends('admin.layouts.master_admin')

@section('page_title')
    {{config('app.name')}} | Dashboard
@endsection

@section('content')

    <section class="errorpage">
        <div class="container-fluid position-relative">
                <div class="row">
                    <div class="col-12 p-0">

                        <div class="col-sm-12 text-center"><br><br><br><br><br>
                            <h1 class="authPageTitle"> Whoops We can't find the page you input!</h1>
                            <a class="btn btn-link" href="{{ url('/admin') }}">Go to Dashboard</a>
                        </div>
                    </div>
            </div>
        </div>
    </section>
@endsection


