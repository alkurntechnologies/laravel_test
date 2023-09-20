@extends('front-user.layouts.dashboard_user')

@section('content')
@php
$imgNotFound = URL::asset('/')."/assets/front-end/images/i-user.png";
@endphp
<style type="text/css">
  #map{ width:700px; height: 500px; }
</style>
<section class="dashboardOuter m-0">
    
    <div class="dashboardDiv">
      <div class="dashboardPageTitle">
        Profile
      </div>
      <div class="operator-profile customer">
        <form method="post" data-parsley-validate enctype="multipart/form-data">
          <div class="row">
          
            <div class="col-12">
              
              <div class="row">
                  @csrf
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label><span class="text-danger">*</span>Name</label>
                    <input type="text" placeholder="Byron" class="form-control" name="name" required data-parsley-required-message="Please enter full name." 
                    value="{{old('name', Auth::user()->name)}}">
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label><span class="text-danger">*</span>Email Id</label>
                    <input type="email" placeholder="byron.jacobs@example.com" class="form-control" name="email" readonly="" 
                    value="{{old('email', Auth::user()->email)}}">
                  </div>
                </div>
               
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="form-group">
                      <label for="position">Profile Picture</label>
                      <div class="inputes">
                          <input type="file" class="simpleFile" id="real-file1" hidden="hidden" name="profile_pic"
                           @if(! Auth::user()->profile_pic )  @endif 
                           data-parsley-required-message="Please  select profile pic." 
                           data-parsley-errors-container="#profileImage" accept="images/*" />
                          <button type="button" class="custom-button-one" id="custom-button-one">Choose File</button>
                          <span class="inputName" id="custom-text1">Please select profile picture</span>
                      </div>
                      @if(Auth::user()->profile_pic)
                      <div class="image-preview-div">
                        <img loading="lazy" src="{{ URL::to('storage/app')."/".Auth::user()->profile_pic}}" width="100"> 
                    </div>
                    @endif

                      <span id="profileImage"></span>
                  </div>
                </div>


              <div class="row">
                <div class="col-sm-4 up-now">
                  <button type="submit" class="blueBtn smallBtn">Update Profile</button>
                </div>
              </div>
              
            </div>

          </form>
          </div>
      </div>

      <!-- <div class="customer-map">
          <img loading="lazy" src="{{ asset('/') }}/assets/front-end/images/map-cust.png" alt="">
      </div> -->
        
    </div><!-- blogSidebar -->
</section>
  
@endsection

@section('script_links')

@endsection

@section('script_codes')

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-preview')
                    .attr('src', e.target.result)
                    .width(141)
                    .height(141);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

   
</script>
@endsection