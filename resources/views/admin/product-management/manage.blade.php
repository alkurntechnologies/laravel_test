@extends('admin.layouts.master_admin')

@section('page_title')
{{config('app.name')}} | Manage Products
@endsection


@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>Manage Products</h1>
                </div>

        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table " id="example1">
                        <thead>
                        <tr>
                            <th class="brRd" id="productImage">Image</th>
                            <th class="brLB" id="productName">Product</th>
                            <th class="brRD" id="bac">Type</th>
                            <th class="brRD" id="nu">Price</th>
                            <th class="brRd" id="lfs">Stock</th>
                            <th class="column-title text-center" id="productAction">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 1;  ?>
                        @foreach($products as $row)
                            <tr>
                                <td>@if($row->images)
                                     @php
                                         $extension = pathinfo($row->images, PATHINFO_EXTENSION); 
                                     @endphp
                                     @if($extension == 'mp4' || $extension == 'mkv' || $extension == 'webm' || $extension == 'mov')
                                         <video src="{{url('storage/app').'/'.$row->images}}" controls="" width="60" height="60"></video>
                                     @else
                                         <img loading="lazy" id="id2" src="{{url('storage/app').'/'.$row->images}}" width="60"  height="60" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                     @endif
                                    @else
                                    <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/trainImage.jpg" width="60" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                    @endif
                                </td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->type}}</td>
                                <td>${{$row->price}}</td>
                                <td>{{$row->stock}}</td>
                                <td class="productAction text-nowrap ">
                                @can('Products-edit')
                                    <a href="{{URL::to('/admin/edit-product',['id'=>@$row->id])}}" class="downloadIcon showDetail" title="Edit"><i class="fa fa-edit fa-fw fa-lg"></i></a>
                                @endcan
                                    @can('Products-delete')
                                    <a href="javascript:void(0);" class="deleteProduct" id="{{@$row->id}}" class="downloadIcon showDetail" title="Delete"><i class="fa fa-trash fa-fw fa-lg"></i></a> 
                                    @endcan
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
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
@endsection
@section('admin_script_codes')
<script>

    $(document).ready(function() {
        $('#example1 thead tr')
      
            
        table = $('#example1').DataTable(
        {
            'iDisplayLength': 20,
            "order": [[ 0, "desc" ]],
            orderCellsTop: true,
            "columnDefs": [
                {
                    "targets": [ 10 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [9],
                    "orderable": false,
                }
            ],
        });
        });


      
    $(document).ready(function () {

            $("#example1").on("click", ".deleteProduct", function (e) {

                e.preventDefault();
                let id = $(this).attr('id');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this Product!",
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
                                url: "{{ url('/admin/delete-product') }}",
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

                                    }
                                    if (response.status == "error") {
                                        toastr.info(response.msg);
                                        setTimeout(function () {
                                            location.reload();
                                        }, 5000)
                                    }
                                }
                            });
                            swal("Deleted!", "Product deleted successfully.", "success");
                        } else {
                            swal("Cancelled", "Product is safe :)", "error");
                        }
                    });
            });
        });

       

</script>
@endsection