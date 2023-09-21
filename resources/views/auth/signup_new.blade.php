@extends('front-user.layouts.master_user')

@section('content')
<section class="loginSection">
    <div class="logImgBox">
        <img loading="lazy" class="position-absolute" src="{{ asset('/') }}/assets/front-end/images/new-banner.jpeg" alt="">
    </div>
    <div class="container">
        <div class="logForm registrationForm">
            <div class="instructionText">
                Fields marked with an <span class="color-red">*</span> are required
            </div>
            <div class="loginBox mt-5">
                {{-- <h3>Sign up</h3> --}}
                <div class="loginRight">  
                                         
                    <div class="authForm">
                        <div class="step-form">                            
                            <div class="step-progress">
                                <span class="progess-show" ></span>
                            </div>
                            <div class="step-button">
                                <ul>
                                    <li class="st-stype  active" id="st1">
                                        About You
                                    </li>
                                    <li class="st-stype  " id="st2">
                                        Your Company
                                    </li>
                                    <li class="st-stype  " id="st3">
                                        Account Type
                                    </li>
                                    <li class="st-stype hidenButton" id="st4">
                                        <span class="usertest"></span> Categories
                                    </li>
                                    <li class="st-stype hidenButton" id="st5">
                                        <span class="usertest"></span> Finance
                                    </li>
                                    <li class="st-stype hidenButton" id="st6">
                                        Password
                                    </li>
                                </ul>
                            </div>
                            <form action="{{url('signup')}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                @honeypot
                                {{-- Common step 1 --}}
                                <div class="step-fields st1-form open" id="st-form-1" data-parsley-validate>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="first_name_buyer">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="first_name_buyer" aria-describedby="emailHelp" placeholder="Enter First Name" name="first_name" required="" data-parsley-required-message="Please enter First Name." value="{{old('first_name')}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="last_name_buyer">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="last_name_buyer" aria-describedby="emailHelp" placeholder="Enter Last Name" name="last_name" required="" data-parsley-required-message="Please enter Last Name." value="{{old('last_name')}}">
                                            </div>
                                        </div>


                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="position_buyer">Position <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="position_buyer" aria-describedby="positionHelp" placeholder="Enter position" name="position" required="" data-parsley-required-message="Please enter position." data-parsley-type-message="Please enter a valid position." value="{{old('position')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="email1_buyer">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email1_buyer" aria-describedby="emailHelp" placeholder="Enter email" name="email" required="" data-parsley-required-message="Please enter email." data-parsley-type-message="Please enter a valid email." value="{{old('email')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="tel">Phone <span class="text-danger">*</span></label>
                                                <input type="phone" class="form-control" id="tel" aria-describedby="phoneHelp" placeholder="Enter phone" name="phone" required="" data-parsley-required-message="Please enter phone." data-parsley-type-message="Please enter a valid phone." value="{{old('phone')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="password3">Password <span class="text-danger">*</span>  <span data-description="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="tootltip"><i class="fa-solid fa-question"></i></span></label>
                                                <div class="password-field">
                                                    <input type="password" class="password form-control" id="password3" placeholder="Password" name="password" 
                                                    required data-parsley-required-message="Please enter password." value="@if (!$errors->has('password')){{old('password')}}@endif"
                                                    data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                    data-parsley-pattern-message="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                                    <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span> 
                                                    <!-- <span class="passChk"><input type="checkbox" id="checkPass"><label for="checkPass"></label></span> -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="reEnterPassword3">Re Enter Password <span class="text-danger">*</span></label>
                                                <div class="password-field">
                                                    <input type="password" class="password form-control" id="reEnterPassword3" name="password_confirmation" data-parsley-equalto="#password3" data-parsley-equalto-message="Password and confirm password should be same." required data-parsley-required-message="Re enter password." placeholder="Re enter password" value="@if (!$errors->has('password_confirmation')){{old('password_confirmation')}}@endif">
                                                    <span class="passView toggle-password"><i class="fi fi-rr-eye"></i></span> 
                                                    <!-- <span class="passChk"><input type="checkbox" id="checkPass1"><label for="checkPass1"></label></span> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttonDiv d-flex">                                        
                                            <button type="button" id="st-btn-1" class="submit blueBtn smallBtn ms-auto">Next</button>
                                        </div>

                                    </div>
                                </div>
                                {{-- Common step 2 --}}
                                <div class="step-fields st2-form" id="st-form-2" data-parsley-trigger="blur" data-parsley-validate>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="company-name_buyer">Company Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="company-name_buyer" aria-describedby="companynameHelp" placeholder="Enter Company Name" name="company_name" required="" data-parsley-required-message="Please enter Company Name." value="{{old('company_name')}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="company-website_buyer">Company Website <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="company-website_buyer" aria-describedby="emailHelp" placeholder="Enter Company Website" name="company_website" required="" data-parsley-required-message="Please enter Company Website." value="{{old('company_website')}}">
                                            </div>
                                        </div>


                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="number-of-employees_buyer">Number of Employees <span class="text-danger">*</span></label>
                                                <select class="form-control" id="number-of-employees_buyer" name="company_size" data-parsley-required-message="Please enter Number of Employees." data-parsley-type-message="Please enter a valid Number of Employees." required="">
                                                    <option value="">Select Employees</option>                                                    
                                                    <option value="1 - 9" @if(old('company_size') ==  '1 - 9') selected @endif>1 - 9</option>                                                    
                                                    <option value="10 - 100" @if(old('company_size') ==  '10 - 100') selected @endif>10 - 100</option>                                                    
                                                    <option value="101 - 500" @if(old('company_size') ==  '101 - 500') selected @endif>101 - 500</option>                                                    
                                                    <option value="501 - 1000" @if(old('company_size') ==  '501 - 1000') selected @endif>501 - 1000</option>                                                    
                                                    <option value="1001" @if(old('company_size') ==  '1001') selected @endif>1001 +</option>                                                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="Annual-Sales_buyer">Annual Sales <span class="text-danger">*</span></label>
                                                <select class="form-control" id="Annual-Sales_buyer" name="revenue" data-parsley-required-message="Please enter Annual Sales." data-parsley-type-message="Please enter a valid Annual Sales." required="">
                                                    <option value="">Select Annual Sales</option>
                                                    <option value="Under 500k" @if(old('revenue') ==  'Under 500k') selected @endif>Under $500k</option>
                                                    <option value="501k - 999" @if(old('revenue') ==  '501k - 999') selected @endif>$501k - $999k</option>
                                                    <option value="1m - 2.49m" @if(old('revenue') ==  '1m - 2.49m') selected @endif>$1m - $2.49m</option>
                                                    <option value="2.5m - 4.9m" @if(old('revenue') ==  '2.5m - 4.9m') selected @endif>$2.5m - $4.9m</option>
                                                    <option value="5m - 9.9m" @if(old('revenue') ==  '5m - 9.9m') selected @endif>$5m - $9.9m</option>
                                                    <option value="10m - 49m" @if(old('revenue') ==  '10m - 49m') selected @endif>$10m - $49m</option>                                               
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="Offering_buyer">Offering <span class="text-danger">*</span></label>
                                                <select class="form-control" id="Offering_buyer" name="offering" data-parsley-required-message="Please enter Offering." data-parsley-type-message="Please enter a valid Offering." required="">
                                                    <option value="">Select Offering</option>	
                                                    <option value="Products" @if(old('offering') ==  'Products') selected @endif>Products</option>
                                                    <option value="Services" @if(old('offering') ==  'Services') selected @endif>Services</option>                                                    
                                                    <option value="Products and Services" @if(old('offering') ==  'Products and Services') selected @endif>Products and Services</option>                                        
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="billing_address">Address <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="billing_address" aria-describedby="emailHelp" placeholder="Enter Address" name="billing_address" required="" data-parsley-required-message="Please enter Address." value="{{old('billing_address')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="state_buyer">State <span class="text-danger">*</span></label>
                                                <select class="form-control" id="state_buyer" name="state" data-parsley-required-message="Please enter State ." data-parsley-type-message="Please enter a valid State ." required="">
                                                    <option value="">Select State</option>
                                                    @foreach($states as $state)
                                                    <option value="{{$state->id}}" @if(old('state') ==  $state->id) selected @endif>{{$state->name}}</option>
                                                    @endforeach
                                                                                              
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="zip_buyer">zip <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="zip_buyer" aria-describedby="emailHelp" placeholder="Enter zip" name="zipcode" required="" data-parsley-required-message="Please enter zip." value="{{old('zipcode')}}">
                                            </div>
                                        </div>
                                    
                              

                                        <div class="buttonDiv d-flex">                                        
                                            <button type="button" id="st-btn-pre-2" class="prevclick blueBtn smallBtn">Previous</button>
                                            <button type="button" id="st-btn-2" class="submit blueBtn smallBtn ms-auto">Next</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- Common step 3 --}}
                                <div class="step-fields st3-form" id="st-form-3" data-parsley-trigger="blur" data-parsley-validate>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Select Account Type  <span class="text-danger">*</span></label>
                                                <div class="custom-radio-outer">
                                                    <div class="custom-radio">
                                                        <input type="radio" class="userType" name="user_type" id="type-1" value="1" @if($user_type == 'buyer' || old('user_type') == '1') checked @endif>
                                                        <label for="type-1">Buyer (Select to buy products, services and create RFQs)</label>
                                                    </div>
                                                    <div class="custom-radio">
                                                        <input type="radio" class="userType" name="user_type" id="type-2" value="2" @if($user_type == 'seller' || old('user_type') == '2') checked @endif>
                                                        <label for="type-2">Seller (Select to sell products, services and respond to RFQs)</label>
                                                    </div>
                                                    <div class="custom-radio">
                                                        <input type="radio" class="userType" name="user_type" id="type-3" value="3" @if($user_type == 'shipper' || old('user_type') == '3') checked @endif>
                                                        <label for="type-3">Shipper (Select to provide shipping services)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-12" id="captchName">
                                                <div class="form-group">
                                                    <div class="g-recaptcha" data-sitekey="{{config('settings.env.NOCAPTCHA_SITEKEY')}}" data-callback="checkCaptcha"></div>

                                                    <input type="text" id="captch_name" data-parsley-required-message="Please confirm you are human..!!" value="" style="display:none">
                                                    @if ($errors->has('g-recaptcha-response'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div> -->
                                            <div class="buttonDiv d-flex">                                        
                                                <button type="button" id="st-btn-pre-3" class="prevclick blueBtn smallBtn">Previous</button>
                                                <button type="button" id="st-btn-3" class="submit blueBtn smallBtn ms-auto">Next</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Common step 4--}}
                                <div class="step-fields st3-form" id="st-form-4" data-parsley-trigger="blur" data-parsley-validate>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for=""><span class="usertest">Selling</span> Categories (Select all that apply) <span class="text-danger">*</span></label>
                                                <div class="custom-check-outer">
                                                    @foreach($categories as $key => $category)
                                                    <div class="custom-check">
                                                        <input type="checkbox" class="form-control" name="category_id[]" id="category-{{$key+1}}" value="{{$category->id}}"
                                                         data-parsley-errors-container="#errorcategory" @if(old('category_id') != null && in_array($category->id, old('category_id'))) checked @endif>
                                                        <label for="category-{{$key+1}}">{{$category->name}}</label>
                                                    </div>
                                                    @endforeach
                                                    <!-- <div class="custom-check">
                                                        <input type="checkbox" name="category" id="category-2" value="2">
                                                        <label for="category-2">Bridge</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" name="category" id="category-3" value="3">
                                                        <label for="category-3">Cranes</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" name="category" id="category-4" value="4">
                                                        <label for="category-4">Intermodal</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" name="category" id="category-5" value="5">
                                                        <label for="category-5">General</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" name="category" id="category-6" value="6">
                                                        <label for="category-6">Leases/Bridges</label>
                                                    </div> -->
                                                </div>
                                                <span id="errorcategory"></span>
                                            </div>
                                            <div class="buttonDiv d-flex">                                        
                                                <button type="button" id="st-btn-pre-4" class="prevclick blueBtn smallBtn">Previous</button>
                                                <button type="button" id="st-btn-4" class="submit blueBtn smallBtn ms-auto">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Common step 4 as buyer--}}
                                <div class="step-fields st3-form" id="st-form-5" data-parsley-trigger="blur" data-parsley-validate>
                                    <div class="buyerForm" >
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Preferred-Payment-Method_buyer">Preferred Payment Method <span class="text-danger">*</span></label>
                                                            <select class="form-control required-class" id="Preferred-Payment-Method_buyer" name="payment_method" data-parsley-required-message="Please enter Preferred Payment Method." data-parsley-type-message="Please enter a valid Preferred Payment Method.">
                                                                <option value="">Select Payment Method</option>
                                                                <option value="Credit Card" @if(old('payment_method') == 'Credit Card') selected @endif>Credit Card</option>                                                    
                                                                <option value="PO Purchase Order" @if(old('payment_method') == 'PO Purchase Order') selected @endif>PO (Purchase Order)</option>                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Preferred-Payment-Method_buyer">Upload W9 </label>
                                                            <label for="file-upload" class="custom-file-upload">
                                                                <i class="fa fa-cloud-upload"></i> Upload Image
                                                            </label>
                                                            <span id="fileName"></span>
                                                            <input id="file-upload" class="required-class" name='w_form' type="file" style="display:none;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sellerForm">
                                        <div class="row">
                                            <div class="col-12">                                            
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="EIN-number_buyer">EIN Number <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-class charCount" id="EIN-number_buyer" aria-describedby="emailHelp" placeholder="Enter EIN Number" name="ein_number" data-parsley-required-message="Please enter EIN Number." 
                                                            value="{{old('ein_number')}}">
                                                            <div class="crt"><span class="leftletter">9</span> of 9</div>
                                                        </div>
                                                    </div>
            
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="DNB-number_buyer">DNB Number </label>
                                                            <input type="text" class="form-control charCount" id="DNB-number_buyer" aria-describedby="emailHelp" placeholder="Enter DNB Number" name="dnb_number" data-parsley-required-message="Please enter DNB Number."
                                                             value="{{old('dnb_number')}}">                                                        
                                                            <div class="crt"><span class="leftletter">9</span> of 9</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Preferred-Payment-Method_buyer">Upload Certifications (Minority, Woman, Vet, Disabled or 501c3 Certifications) </label>
                                                            <label for="multiple-file-upload" class="custom-file-upload">
                                                                Choose File
                                                            </label>
                                                            <span class="filenames"></span>
                                                            <input id="multiple-file-upload" name='certificates[]' type="file" style="display:none;" multiple>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="buttonDiv d-flex">                                        
                                        <button type="button" id="st-btn-pre-5" class="prevclick blueBtn smallBtn">Previous</button>
                                        <button type="submit" id="st-btn-5" class="submit blueBtn smallBtn ms-auto">Submit</button>
                                        <input type="submit" id="submitForm" style="display:none">
                                    </div>
                                </div>
                                <div class="row captcha">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="{{config('settings.env.NOCAPTCHA_SITEKEY')}}" data-callback="checkCaptcha1"></div>

                                            <input type="text" id="captch_name1"  data-parsley-required-message="Please confirm you are human..!!" value="" style="display:none">
                                            @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="lbBtmTxt mt-4">Already Registered? <a href="{{url('login')}}">Sign in</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- loginSection -->
<div class="loaderImage" id="loaderImage">
    <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/loading-image.gif" alt="">
</div>
@endsection

@section('script_links')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
<script src="{{ URL::asset('/assets/admin/plugins/toastr/toastr.min.js') }}"></script>


@endsection

@section('script_codes')
<script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2oRAljHGZArBeQc5OXY0MI5BBoQproWY&amp;libraries=places"></script>
<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('billing_address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            // place variable will have all the information you are looking for.
            // $("#profile_latitude").val(place.geometry['location'].lat());
            // $("#profile_longitude").val(place.geometry['location'].lng());
            console.log(place.geometry['location'].lat());
            console.log(place.geometry['location'].lng());

            const geocoder = new google.maps.Geocoder;
        });
    }
</script>
<script>
      function checkCaptcha()
    {
         $("#captch_name").val("test");
    }

    function checkCaptcha1()
    {
         $("#captch_name1").val("test");
    }

    $('form').submit(function(e){
        $("#loaderImage").show();
    })
    $(document).ready(function(){
    var phones = [{ "mask": "(###) ###-####"}];
        $('#tel').inputmask({ 
            mask: phones, 
            greedy: false, 
            definitions: { '#': { validator: "[0-9]", cardinality: 1}} });
    });


    // $('input[name=user_type]').change(function(){
    // var value = $( 'input[name=user_type]:checked' ).val();
    // alert(value);
    // });
    $("#st-btn-3").hide();
    var userType = @json($user_type);
    if(userType == 'buyer'){
        $("#st4").text("Buyer Categories");
        $("#st5").text("Buyer Finance");
        $(".buyerForm").show();
        $(".sellerForm").hide();
        $("#st4").removeClass("hidenButton");
        $("#st5").removeClass("hidenButton");
        $(".usertest").text("Buyer")
    }else if(userType == 'seller'){
        $("#st4").text("Seller Categories")
        $("#st5").text("Seller Finance")
        $(".sellerForm").show();
        $(".buyerForm").hide();
        $("#st4").removeClass("hidenButton");
        $("#st5").removeClass("hidenButton");
        $(".usertest").text("Seller")
    }else if(userType == 'shipper'){
        $("#st-btn-3").css('display', 'block');
    }

    $('input[name=user_type]').change(function(){
        if($('input[name=user_type]').is(":checked")) {
            $("#st-btn-3").show();
            // $("#st6").removeClass("hidenButton")
        }
        
        if($(this).val() == "1"){
            // $(".buyer-step").removeClass("hidenButton")
            // $(".seller-step").addClass("hidenButton")
            $("#st4").text("Buyer Categories");
            $("#st5").text("Buyer Finance");
            $(".buyerForm").show();
            $(".sellerForm").hide();
            $("#st4").removeClass("hidenButton");
            $("#st5").removeClass("hidenButton");
            $(".usertest").text("Buyer")
            // $(".sellerForm").find(".form-control").attr('required', false)
            // $("#st-btn-3").attr('type', 'button')
            $("#st-btn-3").text("Next")
            $(".progess-show").css("width", "40%")
            $('#captch_name1').attr('required', '');
            $('#captch_name').removeAttr('required');
            $('#captchName').hide();
            $('#captch_name1').show();
            $(this).closest("form").removeClass("showCaptcha");
        }else if($(this).val() == "2"){
            // $(".seller-step")
            // $(".buyer-step").addClass("hidenButton")
            $("#st4").text("Seller Categories")
            $("#st5").text("Seller Finance")
            $(".sellerForm").show();
            $(".buyerForm").hide();
            $("#st4").removeClass("hidenButton");
            $("#st5").removeClass("hidenButton");
            $(".usertest").text("Seller")
            // $(".sellerForm").find(".form-control").attr('required', true)
            // $("#st-btn-3").attr('type', 'button')
            $("#st-btn-3").text("Next")
            $(".progess-show").css("width", "40%")
            $('#captch_name1').attr('required', '');
            $('#captch_name').removeAttr('required');
            $('#captchName').hide();
            $('#captch_name1').show();
            $(this).closest("form").removeClass("showCaptcha");
        }else{
            $("#st-btn-3").attr('type', 'submit')
            $("#st-btn-3").show();
            $("#st4").addClass("hidenButton");
            $("#st5").addClass("hidenButton");
            $("#st-btn-3").text("Submit")
            $('#captch_name').attr('required', '');
            $('#captch_name1').removeAttr('required');
            $('#captchName').show();    
            $('#captch_name').show(); 
            $(this).closest("form").addClass("showCaptcha");
        }
    })
    $(document).ready( function() {
        // Bind the <input> elements for Parsley validation
        // triggered at data-parsley-trigger="change".
        $('.form-control').parsley();
        
        // Bind an onclick handler to the <button>
        // to trigger Parsley validation on all fields upon click.
        $('.submit').click( function(event) {
            event.preventDefault();
            // Validate all input fields.
            var isValid = true;
            $(this).closest(".step-fields").find('.form-control').each( function() {
                if ($(this).parsley().validate() !== true) isValid = false;
            });
            if (isValid) {
                // alert("OK and Processed!");
            }
        });
    });
    $('#captchName').hide();  
    $(document).on("click", ".submit", function(){
        // alert($(this).attr("id"))
        var id = $(this).attr("id").replace("st-btn-","")
        var sec = $(this).attr("id").replace("st-btn-","")
        
        id++
        // alert(id)
        var validation =  false;

        

        if(id == 2)
        {
            if($('#first_name_buyer').val() != '' && $('#last_name_buyer').val() != '' && $('#position_buyer').val() != '' && 
            $('#email_buyer').val() != '' && $('#position_buyer').val() != '' && $('#tel').val() != '' && $('#password3').val() != ''
            && $('#reEnterPassword3').val() != ''){
                validation =  true;
                $("#st"+sec).removeClass("tab-error")
            }else{
                // alert(sec)
                $("#st"+sec).addClass("tab-error")
            }

        }else if(id == 3){
            if($('#company-name_buyer').val() != '' && $('#company-website_buyer').val() != '' && $('#number-of-employees_buyer').val() != '' && 
            $('#Annual-Sales_buyer').val() != '' && $('#Offering_buyer').val() != '' && $('#zip_buyer').val() != '' && $('#state_buyer').val() != ''
            && $('#billing_address').val() != ''){
                validation =  true;
                $("#st"+sec).removeClass("tab-error");
                console.log($("input[name='user_type']:checked").val())
                if($("input[name='user_type']:checked").val() == 1 || $("input[name='user_type']:checked").val() == 2){
                    $('#captch_name').attr('required', '');
                    $('#captch_name1').removeAttr('required');
                    $('#captchName').hide();     
                }else if($("input[name='user_type']:checked").val() == 3){
                    $('#captch_name1').attr('required', '');
                    $('#captch_name').removeAttr('required');
                    $('#captchName').show();   
                }
            }else{
                // alert(sec)
                $("#st"+sec).addClass("tab-error")
            }
        }else if(id == 4){
            if($("input[name='user_type']:checked").val() != NaN){
                
                    validation =  true;
                    $("#st"+sec).removeClass("tab-error")
                    // categories = @json($categories);
                    // categories.each(function(index, currentElement) {
                        
                    // });
                    

                    $("#signupform-password").attr('type', 'password');
            }else{
                // alert(sec)
                $("#st"+sec).addClass("tab-error")
            }
        }else if(id == 5){
            if($("input[name='category_id[]']:checked").val() != undefined){
                validation =  true;
                if($("input[name='user_type']:checked").val() == 1){
                    $('#Preferred-Payment-Method_buyer').attr('required', '');
                    $('#EIN-number_buyer').removeAttr('required');
                }else if($("input[name='user_type']:checked").val() == 2){
                    $('#EIN-number_buyer').attr('required', '');
                    $('#Preferred-Payment-Method_buyer').removeAttr('required');
                    $('#file-upload').removeAttr('required');
                }else{
                    $('#EIN-number_buyer').removeAttr('required');
                    $('#Preferred-Payment-Method_buyer').removeAttr('required');
                    $('#file-upload').removeAttr('required');
                }
                $("#st"+sec).removeClass("tab-error")
            }else{
                // alert(sec)
                $("#st"+sec).addClass("tab-error")
            }
            $(this).closest("form").addClass("showCaptcha");
        }else if(id == 6){
            if($("input[name='user_type']:checked").val() == 1){
              
                if($('#Preferred-Payment-Method_buyer').val() != ''){
                    validation =  true;
                    $("#st"+sec).removeClass("tab-error")
                    $('#submitForm').trigger('click');
                }
            }else if($("input[name='user_type']:checked").val() == 2){
                if($('#EIN-number_buyer').val() != ''){
                    validation =  true;
                    $("#st"+sec).removeClass("tab-error")
                    $('#submitForm').trigger('click');
                }
            }else{
                // alert(sec)
                $("#st"+sec).addClass("tab-error")
            }

        }else{
            $(this).closest("form").removeClass("showCaptcha");
        }
        
        if(validation == true){
            if($("input[name='user_type']:checked").val() != 3){
                console.log($("input[name='user_type']:checked").val());
                $('#st-form-'+sec+' :input:not(:button)').each(function (index, value) { 
                    $(this).parsley().validate();
                    
                    $(".step-fields").removeClass("open");
                    $('#st-form-'+id).addClass("open");
                    $(".st-stype").removeClass("active")
                    $("#st"+id).addClass("active")
                });
            }else if($("input[name='user_type']:checked").val() == 3){
                $('#submitForm').trigger('click');
            }
        }else{
            $(this).closest(".step-fields").find('.form-control').each( function() {
                if ($(this).parsley().validate() !== true) isValid = false;
            });
            // toastr.error('Please enter all the required information !');
        }

    })
    $(document).on("click", ".prevclick", function(){
        // alert($(this).attr("id"))
        var id_prev = $(this).attr("id").replace("st-btn-pre-","")
        // alert(id)
        var sec_prev = (id_prev - 1)

        $('.step-fields').removeClass("open");
        $('#st-form-'+sec_prev).addClass("open");
        $(".st-stype").removeClass("active")
        $("#st"+sec_prev).addClass("active")
        $(this).closest("form").removeClass("showCaptcha");
    })
    $(document).on("click", ".st-stype", function(){
        $('.step-fields.open :input:not(:button)').each(function (index, value) { 
            $(this).parsley().validate();
        });
        if($(".step-fields.open .form-control").hasClass('parsley-error')){
            
            return false
        }else{
            // return true
        }
        var stpcl = $(this).attr("id").replace("st","")
        $(".st-stype").removeClass("active")
        $(this).addClass("active");
        $(".step-fields").removeClass("open");
        $('#st-form-'+stpcl).addClass("open");
        $("form").removeClass("showCaptcha");
    })



    // Single file upload
    $('#file-upload').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#file-upload')[0].files[0].name;
        $("#fileName").text(file);
    });
    // multiple file upload
    $(function() {
        $('#multiple-file-upload').change(function(){
            for(var i = 0 ; i < this.files.length ; i++){
            var fileName = this.files[i].name;
            $('.filenames').append('<div class="name">' + fileName + '</div>');
            }
        });
    });
$(document).on("click", "#st5", function(){
    $("form").addClass("showCaptcha");
})
    // count
    $('.charCount').keypress(function(){

        if(this.value.length > 9){
            return false;
        }
        $(this).closest(".form-group").find(".leftletter").html((9 - this.value.length));
    });


    $(document).on("click", "body", function(){
        if($("#st1").hasClass("active")){
            $(".progess-show").css("width", "33.33%")
        }else if($("#st2").hasClass("active")){
            $(".progess-show").css("width", "66.66%")
        }else if($("#st3").hasClass("active")){
            $(".progess-show").css("width", "99.99%")
        }else if($('input[name=user_type]').val() <= "2"){
            if($("#st1").hasClass("active")){
                $(".progess-show").css("width", "20%")
            }
            if($("#st2").hasClass("active")){
                $(".progess-show").css("width", "40%")
            }
            if($("#st3").hasClass("active")){
                $(".progess-show").css("width", "60%")
            }
            if($("#st4").hasClass("active")){
                $(".progess-show").css("width", "80%")
            }
            if($("#st5").hasClass("active")){
                $(".progess-show").css("width", "100%")
            }
        }
    })

</script>

@endsection