@extends('front-user.layouts.dashboard_user')

@section('content')
<section class="dashboardOuter m-0">
    
    <div class="dashboardDiv">
      <div class="dashboardPageTitle">
        Profile
      </div>
      <div class="operator-profile customer">
        <div class="row">
          <div class="col-sm-12">
            <form class="change-status" method="post" data-parsley-validate>
              @csrf
            <div class="row"> 
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label><span class="text-danger">*</span>Current Password</label>
                    <div class="password-field">
                      <input type="password" class="form-control password" placeholder="Enter current password" name="current_password" 
                      required="" data-parsley-required-message="Please enter current password" >
                      <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label><span class="text-danger">*</span>New Password 
                      <span data-description="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="tootltip"><i class="fa-solid fa-question"></i></span>
                    </label>
                    <div class="password-field">
                      <input type="password" class="form-control password" placeholder="Enter new password" name="password" 
                      id="password" required="" data-parsley-required-message="Please enter new password"
                      data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                      data-parsley-pattern-message="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                      <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label><span class="text-danger">*</span>Re-Enter New Password</label>
                    <div class="password-field">
                      <input type="password" class="form-control password" placeholder="Re enter new password" name="password_confirmation" required="" data-parsley-required-message="Please enter current password" data-parsley-equalto="#password" data-parsley-equalto-message="New password and confirm password must be equal" >
                      <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span>
                    </div>
                  </div>
                </div>
              <div class="col-12 up-now">
                <button type="submit" class="blueBtn smallBtn">Update Password</button>
              </div>
            </div>
            </form>

          </div>

          
        </div>
      </div>
      
  </div><!-- blogSidebar -->
</section>

@endsection

@section('script_links')
<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>

@endsection

@section('script_codes')
<script>
    $(document).ready(function(){
      $("form.change-status").on("submit", function(event){
          $("#overlay1").show();
      });
  });
</script>
@endsection