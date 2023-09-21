@extends('admin.layouts.master_admin')

@section('page_title')
    {{config('app.name')}} | Change Password
@endsection

@section('admin_script_links')

@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                            @endif

                            @if(Session::get('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    {{Session::get('error')}}
                                </div>
                            @endif

                            @if(Session::get('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    {{Session::get('success')}}
                                </div>
                            @endif
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                    <form action="{{URL::to('admin/update-admin-password')}}" method="post" enctype="multipart/form-data" data-parsley-validate>
                                        @csrf
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Current password <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="oldpassword"
                                                       placeholder="Enter old password" required data-parsley-required-message="Please enter old password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">New Password <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="password"
                                                       placeholder="Enter new password" required data-parsley-required-message="Please enter new password" id="password1">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Confim Password <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                       placeholder="Enter confirm password" required data-parsley-required-message="Please enter confirm password" data-parsley-equalto="#password1" data-parsley-equalto-message="New password and confirm password must be equal" >
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger colorone">Change password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

@endsection

@section('admin_script_codes')
    <script>




    </script>
@endsection



