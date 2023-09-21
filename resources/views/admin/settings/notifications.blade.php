@extends('admin.layouts.master_admin')

@section('page_title')
{{config('app.name')}} | Notifications
@endsection


@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notifications</h1>
                </div>

                <!-- <div class="col-sm-6 text-right">
                    <a href="{{Request::root()}}/admin/add-blog" class="btn-bg-blue color-blue pull-right"><i class="fa fa-plus"></i> Add Blog</a>
                </div> -->
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="example1">
                        <tbody>
                            @foreach($notifications as $i => $notification)
                            <tr>
                                <td class="text-nowrap align-top dateTime">{{Date('M d, Y', strtotime($notification->created_at))}}<br />{{Date('h:i A', strtotime($notification->created_at))}}</td>
                                <td>
                                @if(@$notification->data['link'] == "")
                                    <a class="notification">{{@$notification->data['msg']}}</a>  
                                @else
                                    <a class="notification">{{@$notification->data['msg']}}</a>
                                    <a href="{{$notification->data['link']}}" target="_blank" class="float-right"><i class="fas fa-eye    "></i></a>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{--Footer--}}
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection


@section('admin_script_links')  
@endsection
@section('admin_script_codes')
<script>
    $(document).ready(function() {
        $('#example1').DataTable(
        {
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                }
            ]
        });
    } );
</script>
@endsection