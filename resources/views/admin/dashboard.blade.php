@extends('admin.layouts.master_admin')

@section('page_title')
    {{config('app.name')}} | Dashboard
@endsection

@section('content')


    <section class="content">
        <div class="container-fluid pt-4">
            <!-- Small boxes (Stat box) -->
            <div class="row">
            @can('Users-view')
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box color-green">
                        <div class="dashCountInner">
                            <div class="inner">
                                <h3>{{$count->buyers}}</h3>

                                <p>Total Users</p> 
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{url('admin/manage-buyers')}}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            @endcan
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>

@endsection


