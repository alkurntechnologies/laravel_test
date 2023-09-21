@extends('admin.layouts.master_admin')

@section('page_title')
    {{config('app.name')}} | Profile
@endsection

@section('admin_script_links')

@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
              
                <div class="col-md-12">
                    <div class="card">
                       
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                    <form action="{{URL::to('admin/update-admin-profile')}}" method="post" enctype="multipart/form-data" data-parsley-validate>
                                        @csrf
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name"
                                                       placeholder="First name" value="{{Auth::user()->name}}" required="" data-parsley-required-message="Please enter first name.">
                                            </div>
                                        </div>

                                        <!-- <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="last_name"
                                                       placeholder="Last name" value="{{Auth::user()->last_name}}" required="" data-parsley-required-message="Please enter last name.">
                                            </div>
                                        </div> -->

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email"
                                                       placeholder="Email" value="{{Auth::user()->email}}" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail4">Profile Pic</label>
                                            <?php
                                            if(Auth::User()->profile_pic == '' || Auth::User()->profile_pic == null)
                                                $src = URL::asset('/')."/assets/admin/img/default-profile-pic.png";
                                            else
                                                $src = URL::to('storage/app')."/".Auth::User()->profile_pic;
                                            ?>
                                            <img loading="lazy" src="{{$src}}" height="100" width="100"><br/>

                                            <label for="exampleInputEmail4">Update Profile Pic</label>
                                            <input type="file" class="form-control img-upload-tag" name="profile_pic"
                                                   id="profile_pic" data-parsley-required-message="Please upload main photo." data-parsley-fileextension="jpg,jpeg,png,JPG,JPEG,PNG">
                                            @if ($errors->has('profile_pic'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('profile_pic') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
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

        $(document).ready(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#admin_profile_avatar').attr('src', e.target.result);
                        $('#adminProfileImgSidebar').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#adminProfileImg").change(function(){


                readURL(this);
            });
        })



    </script>
@endsection



