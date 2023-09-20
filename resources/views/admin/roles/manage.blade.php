@extends('admin.layouts.master_admin')

@section('page_title')
{{config('app.name')}} | Manage Roles
@endsection


@section('content')


<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Roles</h1>
                </div>
                <!-- @can('Roles-create')
                <div class="col-sm-6 text-right">
                    <a href="{{Request::root()}}/admin/add-role" class="btn btn-success btn-gold-styled pull-right"><i class="fa fa-plus"></i> Add Role</a>
                </div>
                @endcan -->
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
                        <thead>
                        <tr>
                            <th class="column-title">Created At </th>
                            <th class="column-title">Name </th>
                            <th class="column-title text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;  ?>
                        @foreach($result as $row)
                            <tr>

                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->name }}</td>
                                <td class="text-center" style="white-space:nowrap;">
                                @can('Roles-edit')
                                    <a href="{{URL::to('/admin/edit-role',['id'=>$row->id])}}" title="Edit"><i class="fa fa-edit fa-fw fa-lg"></i></a>
                                @endcan
                                <!-- @can('Roles-delete')   
                                    <a href="javascript:void(0);" class="deleteRole" id="{{$row->id}}" title="Delete"><i class="fa fa-trash fa-fw fa-lg"></i></a>
                                @endcan -->
                                </td>

                            </tr>
                            <?php $i++; ?>
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
                    "visible": true,
                    "searchable": false
                },
                {
                    "targets": [2],
                    "orderable": false
                }
            ]
        });
    } );
</script>
<script type="text/javascript">
    $(document).ready(function () {

            $("#example1").on("click", ".deleteRole", function (e) {

                e.preventDefault();
                let id = $(this).attr('id');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this Role!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel please!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "post",
                                url: "{{ url('/admin/delete-role') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id": id
                                },
                                success: function (response) {

                                    if (response.status == "success") {
                                        toastr.success(response.msg);

                                        setTimeout(function () {
                                            location.reload();
                                        }, 5000)

                                        swal("Deleted!", "Role deleted successfully.", "success");
                                    }
                                    if (response.status == "error") {
                                        toastr.error(response.msg);
                                        setTimeout(function () {
                                            location.reload();
                                        }, 5000)
                                        swal("Error!", "You can not delete Role as there are some active users in it.", "error");
                                    }
                                }
                            });
                            
                        } else {
                            swal("Cancelled", "Role is safe :)", "error");
                        }
                    });
            });
        });

    

</script>
@endsection