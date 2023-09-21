@extends('front-user.layouts.master_user')

@section('content')
<?php 
$formData = Session::get('formData');
?>
<section class="cartPage py-4">
    <div class="container">
        <div class="row">
        @if(count($cartDetails) > 0)
            <div class="col-12">
                <div class="inerPageHeading">
                Checkout
                </div>
                <form id="payment-form" method="post" data-secret="{{$intent->client_secret}}" data-parsley-validate>
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                        <?php $total = 0; ?>
                            @foreach($cartDetails as $cart)
                                @if($cart->product)
                                <?php $total += $cart->product->price; ?>
                                    <div class="chekoutdataOne">
                                        <div class="cartTable">
                                            <div class="d-md-table">
                                                <div class="d-md-table-row">
                                                    <div class="d-md-table-cell">
                                                        <div class="itemImage">
                                                        @if($cart->product->images)
                                                            @php
                                                                $extension = pathinfo($cart->product->images, PATHINFO_EXTENSION); 
                                                            @endphp
                                                            @if($extension == 'mp4' || $extension == 'mkv' || $extension == 'webm' || $extension == 'mov')
                                                                <video src="{{url('storage/app').'/'.$cart->product->images}}" controls="" width="100" height="100"></video>
                                                            @else
                                                                <img loading="lazy" id="id2" src="{{url('storage/app').'/'.$cart->product->images}}" width="100"  height="100" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                                            @endif
                                                            

                                                        @else
                                                            <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/trainImage.jpg" class="managproduct" width="100" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                                        @endif
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="d-md-table-cell">
                                                        <div class="productInfo">
                                                            <span class="location">Name: {{$cart->product->name}}</span>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="d-md-table-cell">
                                                        <span class="cartTopPrice" class="cartTopPrice{{$cart->product_id}}" id="cartTopPrice{{$cart->product->id}}" data-price="{{$cart->product->is_on_sale == 1 ?$cart->product->sale_price : $cart->product->price}}">
                                                        ${{ ($cart->product->price>0)?number_format($cart->product->price,2):$cart->product->price }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="shipping-address-section">
                                            <div class="shipping-address-section-content">
                                                <div class="lcTitle">Shipping Address</div>
                                                <div class="lcName">    
                                                    <input type="text" class="form-control" id="fullname1" aria-describedby="emailHelp" 
                                                    placeholder="Enter  Name" name="name" 
                                                    data-parsley-required-message="Please enter  Name." value="{{old('name', Auth::user()->name)}}">
                                                </div>
                                                <div class="lcSecond">
                                                <input type="text" class="form-control" id="address" aria-describedby="emailHelp" placeholder="Enter email" 
                                                    name="address"  data-parsley-required-message="Please enter email."
                                                    data-parsley-type-message="Please enter address." 
                                                    value="" >
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            @endforeach
                            <input type="hidden" id="total" name="total" value="{{$total}}" >
                            <div class="paymentSection">
                                <div class="ptmTlt">Payment</div>
                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="payment-errors" id="card-errors" style="color: red;margin-top:10px;"></span>
                                    </div>
                                </div>  
                               

                                <div class="sripeDiv">
                                    <div id="card-element">
                                        
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="btnLink m-0 mt-2 form_submit" id="card-button">Pay<span id="totalPay"> ${{number_format($total, 2)}}</span></a>
                        </div>
                    
                        
                    </div>
                   
                    <input type="submit" style="display:none" id="submitForm">
                </form>
            </div>
        @else
        Your cart is empty !
        @endif
        </div>
    </div>

</section>
<div class="loaderImage" id="loaderImage">
    <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/loading-image.gif" alt="">
</div>
@endsection

@section('script_links')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>


<script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2oRAljHGZArBeQc5OXY0MI5BBoQproWY&amp;libraries=places"></script>
@endsection

@section('script_codes')

<script  src="https://js.stripe.com/v2/"></script>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
   
 var style = {
          base: {
              color: '#32325d',
              lineHeight: '18px',
              fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
              fontSmoothing: 'antialiased',
              fontSize: '16px',
              '::placeholder': {
                  color: '#aab7c4'
              }
          },
          invalid: {
              color: '#fa755a',
              iconColor: '#fa755a'
          }
      };
     
      const stripe = Stripe('{{ config("settings.env.STRIPE_KEY") }}', { locale: 'en' }); // Create a Stripe client.
      const elements = stripe.elements(); // Create an instance of Elements.
      const card = elements.create('card', { style: style }); // Create an instance of the card Element.

      card.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

      card.on('change', function(event) {
          var displayError = document.getElementById('card-errors');
          if (event.error) {
              displayError.textContent = event.error.message;
          } else {
              displayError.textContent = '';
          }
      });
     

      var form = document.getElementById('payment-form');
      form.addEventListener('submit', function(event) {
          event.preventDefault();

          stripe.createToken(card).then(function(result) {
              if (result.error) {
                  // Inform the user if there was an error.
                  var errorElement = document.getElementById('card-errors');
                  errorElement.textContent = result.error.message;
              } else {
                  // Send the token to your server.
                  stripeTokenHandler(result.token);
              }
          });
      });

      // Submit the form with the token ID.
      function stripeTokenHandler(token) {
          // Insert the token ID into the form so it gets submitted to the server
          var form = document.getElementById('payment-form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token.id);
          form.appendChild(hiddenInput);

          // Submit the form
          form.submit();
      }

$('.form_submit').click(function(){
  $('#submitForm').trigger('click');
});
</script>
@endsection