@extends('front-user.layouts.master_user')

@section('content')
<?php
$favProduct = null;
$showStyle = "display:none";
$hideStyle = "display:block";
$qty = 1;
if(Auth::check()){
    if($cartDetail = App\Models\CartDetail::whereUserId(Auth::id())->whereProductId($product->id)->first()){
        $showStyle = "display:block";
        $hideStyle = "display:none";
        $qty = $cartDetail->quantity;
    }

    $favProduct = App\Models\FavoriteProduct::whereUserId(Auth::id())->whereProductId($product->id)->first();
}else{
    if(Session::has('sessionId'))
    {
        $sessionId = Session::get('sessionId');
        if($cartDetail = App\Models\CartDetail::whereSessionId($sessionId)->whereProductId($product->id)->first()){
            $showStyle = "display:block";
            $hideStyle = "display:none";
            $qty = $cartDetail->quantity;
        }
    }
}

?>
<section class="prodctDetail">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="product-detail-image">
                    @if($product->images)
                        <div class="productImage swiper-container">
                            <div class="swiper-wrapper align-items-center">
                                @foreach(explode(',',$product->images) as $img)
                           
                                    @if(str_contains($img,'http'))
                                        <div class="swiper-slide">
                                            <img loading="lazy" src="{{$img}}"   onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'" class="img-fluid" >
                                            {{-- <div class="hoverSliderOuder">
                                                <div class="hoverSlider">danella_hi-rail</div>
                                            </div> --}}
                                        </div>
                                    @else
                                        @php
                                            $extension = pathinfo($img, PATHINFO_EXTENSION); 
                                        @endphp
                                        @if($extension === 'mp4' || $extension === 'mkv' || $extension === 'webm' || $extension === 'mov')
                                        <div class="swiper-slide">
                                            <video loading="lazy" src="{{url('storage/app').'/'.$img}}" controls=""></video>
                                        </div>
                                        @else  
                                        <div class="swiper-slide">
                                            <img loading="lazy" src="{{url('storage/app').'/'.$img}}" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                            {{-- <div class="hoverSliderOuder">
                                                <div class="hoverSlider">danella_hi-rail</div>
                                            </div> --}}
                                        </div>
                                        @endif
                                    @endif
                           
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <div class="slider-nav swiper-container">
                            <div class="swiper-wrapper align-items-center">
                                @foreach(explode(',',$product->images) as $img)                           
                                    @if(str_contains($img,'http'))
                                        <div class="swiper-slide">
                                            <img loading="lazy" src="{{$img}}"   onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'" class="img-fluid" >
                                        </div>
                                    @else
                                        @php
                                            $extension = pathinfo($img, PATHINFO_EXTENSION); 
                                        @endphp
                                        @if($extension === 'mp4' || $extension === 'mkv' || $extension === 'webm' || $extension === 'mov')
                                        <div class="swiper-slide">
                                            <video loading="lazy" src="{{url('storage/app').'/'.$img}}" controls=""></video>
                                        </div>
                                        @else  
                                        <div class="swiper-slide">
                                            <img loading="lazy" src="{{url('storage/app').'/'.$img}}" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                        </div>
                                        @endif
                                    @endif
                            
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="swiper-slide">
                            <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/trainImage.jpg"   onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'" class="img-fluid" >
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-detail-info">
                    <div class="ContentContentSecond">
                        <h1 class="clientName">{{$product->name}}</h1>
                        <?php                              

                            $categories = explode(',',$product->category_id);
                            $category_names = [];
                            foreach($categories as $id)
                            {
                                $product_category = App\Models\ProductCategory::find($id);
                                if($product_category){
                                    $category_names [] = $product_category->name;
                                }
                            }
                        ?>
                        <div class="dtrt ont">{{implode(', ', $category_names)}} · {{($product->product_type!='')?ucfirst($product->product_type):'Used'}} · @if(($product->price != null && is_numeric($product->price) ) && $product->price > 0 && $product->is_rfq == 0)  Buy Now @else RFQ @endif</div>

                        <p class="location m-0">
                            @if($product->user) Sold by:<a href="{{url('seller-profile/'.$product->user_id)}}"> @if($product->user->company_name) {{ucfirst($product->user->company_name)}} @else {{ ucfirst($product->user->first_name) }} {{ ucfirst($product->user->last_name) }} @endif</a> @endif
                        </p>
                        <p class="location m-0">
                            Item Location: {{$product->location}}
                        </p>
                        <div class="reviewCount mt-5">
                            <?php 
                                if($product->average_rating != null)
                                {
                                    $number = $product->average_rating;
                                    $average_stars =  ($number * 2) / 2;
                                    $drawn = 5; 
                                    for ($i = 0; $i < floor($average_stars); $i++)
                                    {
                                        $drawn--;
                                        echo '<i class="fas fa-star filled"></i> ';
                                    }
                                    // echo $number - floor($average_stars);
                                    if ($number - floor($average_stars) > 0.5)
                                    {
                                        $drawn--;
                                        echo ' <i class="fas fa-star-half-alt filled"></i> ';
                                    }

                                    for($i = $drawn; $i > 0; $i--)
                                    {
                                        echo ' <i class="far fa-star filled"></i> ';
                                    }
                                }else{
                                    echo ' <i class="fi fi-sr-star"></i>
                                    <i class="fi fi-sr-star"></i>
                                    <i class="fi fi-sr-star"></i>
                                    <i class="fi fi-sr-star"></i>
                                    <i class="fi fi-sr-star"></i>';
                                }
                            ?>
                            <?php
                                $price = 0;
                                $adminCommision = App\Models\AdminCommission::first();
                                if($product->user && ($product->price != null && is_numeric($product->price) ) && $product->price > 0 && $product->is_rfq == 0){
                                    $membership = App\Models\UserMembershipPlan::whereUserId($product->user->id)->whereStatus('Active')->latest()->first();
                                        if($product->user->commission > 0)
                                        {
                                            $commission = $product->price * $product->user->commission / 100;
                                        }elseif($product->user->company && $product->user->company->commission > 0)
                                        {
                                            $commission = $product->price * $product->user->company->commission / 100;
                                        }elseif($membership)
                                        {
                                            $plan = App\Models\SubscriptionPlan::whereName($membership->membership_plan)->first();

                                            if($plan){
                                                $commission = $product->price * $plan->commission / 100;
                                            }else{
                                                $commission = $product->price * $adminCommision->seller_commission / 100;
                                            }
                                        }else{
                                            $commission = $product->price * $adminCommision->seller_commission / 100;
                                        }

                                    $price = ceil($product->price + $commission);
                                }

                                $salePrice = 0;
                                if( $product->is_on_sale == true){
                                    if($product->user->commission > 0)
                                    {
                                        $commission = $product->sale_price * $product->user->commission / 100;
                                    }elseif($product->user->company && $product->user->company->commission > 0)
                                    {
                                        $commission = $product->sale_price * $product->user->company->commission / 100;
                                    }elseif($membership)
                                    {
                                        $plan = App\Models\SubscriptionPlan::whereName($membership->membership_plan)->first();

                                        if($plan){
                                            $commission = $product->sale_price * $plan->commission / 100;
                                        }else{
                                        $commission = $product->sale_price * $adminCommision->seller_commission / 100;
                                        }
                                    }else{
                                        $commission = $product->sale_price * $adminCommision->seller_commission / 100;
                                    }
                        
                                    $salePrice = ceil($product->sale_price + $commission);
                                }
                            ?>
                        </div>
                        <div class="d-flex">
                            <a href="javascript:void(0)" onclick="favoriteProduct({{$product->id}})" class="favoritBtns">
                                
                                @if($favProduct)                            
                                <div class="favorit-icon favorit-on big favProduct{{$product->id}}"></div>
                                @else
                                <div class="favorit-icon favorit-off big favProduct{{$product->id}}"></div>
                                @endif
                            </a>
                            <!-- <a href="javascript:void(0)" class="favoritBtns">
                                <svg class="svg-inline--fa fa-eye h-none" style="color: #1eb5db;" aria-hidden="true" focusable="false" data-prefix="far" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"></path></svg>
                                <svg class="svg-inline--fa fa-eye h-yes" style="color: #1eb5db;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                            </a> -->
                        </div>
                        <div class="location darkOne">
                            Dimensions
                            <span class="dtrt">Length: {{$product->product_length}}' Width: {{$product->product_width}}' Height {{$product->product_height}}' Weight: {{$product->product_weight}} lbs</span>
                        </div>
                        <div class="location ">
                            Freight Class: {{$product->freight_class}}
                        </div>
                        <div class="location ">Brand: {{$product->brand_name}}</div>
                        <div class="location ">
                            NMFC Code: {{$product->nmfc_code}}
                        </div>
                        <div class="location ">Buy America Compliant : {{$product->buy_america_compliant}}</div>
                        <div class="location ">Lead time : {{$product->lead_time}} weeks</div>
                        <div class="location my-4">
                            <!-- April 25 2023 -->
                        </div>

                        <p class="price-content">
                            <span class="smalHeading">Price:</span> 
                            <span class="bigFont">
                                @if(($product->price != null && is_numeric($product->price) ) && $product->price > 0 && $product->is_rfq == 0)${{  ($price>0)?number_format($price,2):$price }}  
                                    <span class="price "></span> 
                                @else 
                                    <span class=""><a href="{{url('new-rfq', $product->id)}}" >Request RFQ </a> </span> 
                                @endif
                            </span>
                        </p>
                        @if($product->is_on_sale == true)
                        <p class="price-content">
                            <span class="smalHeading">Sale Price:</span> 
                            <span class="bigFont">
                                ${{$salePrice}}
                            </span>
                        </p>
                        @endif
                        <div class="inputQty">
                            <div class="location ">Quantity</div>
                            <?php 
                                $max = 10;
                            ?>
                            <div class="input-group">
                                <button type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 "  id="{{$product->id}}" data-field="quantity"><i class="fa-solid fa-minus"></i></button>
                                <input type="text" step="1" data-parsley-min="1" data-parsley-max="{{$max}}"  data-parsley-max-message="Please select quantity less than equal to {{$max}}" data-parsley-errors-container="#cartQty"
                                value="{{$qty}}" name="quantity" id="quantity" class="quantity-field border-0 text-center">
                                <button type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " id="{{$product->id}}" data-field="quantity"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <span id="cartQty"></span>
                        
                        <div class="btnDiv">
                            @if((($product->price != null && is_numeric($product->price) ) && $product->price > 0 && $product->is_rfq == 0) || $product->is_on_sale == true)
                            <a href="javascript:void(0)" id="addToCart" data-id="{{$product->id}}" class="cartBtns">
                                <span id="removeCart{{$product->id}}" style={{$showStyle}} > Remove from cart </span>
                                <span id="cart{{$product->id}}" style={{$hideStyle}} > Add to cart </span>
                            </a>
                            @else
                            
                            @endif
                            {{-- <a href="javascript:void(0)" onclick="favoriteProduct({{$product->id}})" class="favoritBtns"><i id="favProduct{{$product->id}}" class="fi @if($favProduct) fi-sr-heart @else fi-rr-heart @endif  favProduct{{$product->id}}"></i></a> --}}
                        </div>
                        <div>
                      @if(Auth::check())  Questions About This Item? <a href="#" data-bs-toggle="modal" data-bs-target="#inquiryModal">Click here</a> @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail-padding-top">
            <div class="row">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="detailHeading">
                        Item Description
                    </div>
                    <div class="detailText">
                        {!! $product->description !!} 
                    </div>
                </div>
    
                <!-- <div class="col-lg-4 col-md-6 col-12">
                    <div class="detailHeading">
                        Item Specifications
                    </div>
                    <div class="detailText">
                        <ul>
                            <li>6-Person Crew Cab</li>
                            <li>Diesel Engine</li>
                            <li>Variety of Configurations</li>
                            <li>56,000 lbs GVWR</li>
                            <li>Hydraulic crane with 74,000’/lbs rating.</li>
                            <li>3-section hydraulic boom extension</li>
                            <li>Hydraulic Tool Circuit with 5/10 GPM Circuits</li>
                            <li>2 Electric rewind hydraulic hose reels</li>
                            <li>45’ hose assemblies with quick disconnects</li>
                            <li>Wide variety of vertical, underbody and walkup compartments on both sides</li>
                            <li>Hi-Rail package for rail operation</li>
                        </ul>
                    </div>
                </div> -->
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="detailHeading">
                        Item Downloads
                    </div>
                    <div class="detailText">
                        <div class="downloadItemouter">
                            <div class="downloadItem">
                                @if($product->specification)
                                <a href="{{url('storage/app').'/'.$product->specification}}" download>
                                    <svg class="svg-inline--fa fa-file-invoice" style="--fa-primary-color: #c60000; --fa-secondary-color: #c60000;" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="file-invoice" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><g class="fa-duotone-group"><path class="fa-secondary" fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zm0 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 112c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256zM224 432c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16z"></path><path class="fa-primary" fill="currentColor" d="M384 160L224 0V128c0 17.7 14.3 32 32 32H384zM96 224c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H288c17.7 0 32-14.3 32-32V256c0-17.7-14.3-32-32-32H96zm0 32H288v64H96V256zM240 416c-8.8 0-16 7.2-16 16s7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H240z"></path></g></svg>
                                    Document
                                </a>
                                @endif
                            </div>
                            <!-- <div class="downloadItem">
                                <a href="#" download>
                                    <svg class="svg-inline--fa fa-file-invoice" style="--fa-primary-color: #c60000; --fa-secondary-color: #c60000;" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="file-invoice" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><g class="fa-duotone-group"><path class="fa-secondary" fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zm0 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 112c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256zM224 432c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16z"></path><path class="fa-primary" fill="currentColor" d="M384 160L224 0V128c0 17.7 14.3 32 32 32H384zM96 224c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H288c17.7 0 32-14.3 32-32V256c0-17.7-14.3-32-32-32H96zm0 32H288v64H96V256zM240 416c-8.8 0-16 7.2-16 16s7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H240z"></path></g></svg>
                                    Document
                                </a>
                            </div>
                            <div class="downloadItem">
                                <a href="#" download>
                                    <svg class="svg-inline--fa fa-file-invoice" style="--fa-primary-color: #c60000; --fa-secondary-color: #c60000;" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="file-invoice" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><g class="fa-duotone-group"><path class="fa-secondary" fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zm0 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 112c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256zM224 432c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16z"></path><path class="fa-primary" fill="currentColor" d="M384 160L224 0V128c0 17.7 14.3 32 32 32H384zM96 224c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H288c17.7 0 32-14.3 32-32V256c0-17.7-14.3-32-32-32H96zm0 32H288v64H96V256zM240 416c-8.8 0-16 7.2-16 16s7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H240z"></path></g></svg>
                                    Document
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detailHeading">
                        Reviews
                    </div>
                    @if(count($reviews) > 0)
                        @foreach($reviews as $review)  
                            <div class="greybg reviewGreyBox wow fadeInUp">  
                                <div class="reviewerImg"> 
                                    @php 
                                    if($review->user->profile_pic == '' || $review->user->profile_pic == null)
                                    $src = URL::asset('/')."/images/default-profile-pic.png";
                                    else
                                    $src = url('storage/app').'/'.$review->user->profile_pic;
                                    @endphp
                                    <div class="img-usr">
                                        <img loading="lazy" src="{{$src}}" alt=""> 
                                    </div>
                                </div>  
                                <div class="reviewerInfo"> 
                                    <div class="userName">{{$review->user->first_name}} {{$review->user->last_name}}</div>
                                    <div class="rating"> 
                                        @for($i=0;$i<5;$i++)
                                            @if($review->rating >$i)
                                            <i class="fas fa-star"></i>
                                            @else
                                            <i class="far fa-star"></i> 
                                            @endif
                                        @endfor
                                        <span>{{number_format((float)$review->rating, 1, '.', '')}} </span> 
                                    </div>
                                    <p class="timeReview">{{ date('m-d-Y',strtotime($review->created_at))}}</p> 
                                    <h5 class="reviewText">{{$review->review}}</h5>
                                </div> 
                            </div>
                        @endforeach
                    @else
                        No reviews yet !
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-details">
                    <!-- tabs links-->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button" role="tab" aria-controls="specification" aria-selected="false">Specification</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li> --}}
                    </ul>
                    <!-- tabs content-->
                    <div class="tab-content" id="myTabContent">
                        {{-- <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p>  </p>
  
                            <!-- <p>Brand name : {{$product->brand_name}} </p>  -->
                            <p>Location :  </p>     
                           
                            <p> </p>  
                            <p>Buying format :  </p>   
                            <p> </p> 
                            <p>Freight Class :  </p> 
                        </div> --}}
                        <div class="tab-pane fade" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                            
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">

            <header class="section-header">
                {{-- <h2>Our Clients</h2> --}}
                <p>Related Products</p>
            </header>
    
            <div class="clients-slider-second swiper">
                <div class="swiper-wrapper align-items-center">
                    @foreach($related_product as $row)
                    <?php
                        $favProduct = null;
                        $style = "display:none";
                        $nstyle = "display:block";
                        if(Auth::check()){
                            if($cartDetail = App\Models\CartDetail::whereUserId(Auth::id())->whereProductId($row->id)->first()){
                                $style = "display:block";
                                $nstyle = "display:none";
                            }

                            $favProduct = App\Models\FavoriteProduct::whereUserId(Auth::id())->whereProductId($row->id)->first();
                        }else{
                            if(Session::has('sessionId'))
                            {
                                $sessionId = Session::get('sessionId');
                                if($cartDetail = App\Models\CartDetail::whereSessionId($sessionId)->whereProductId($row->id)->first()){
                                    $style = "display:block";
                                    $nstyle = "display:none";
                                }
                            }
                        }
                    ?>
                    <div class="swiper-slide d-flex">            
                        <div class="count-box-second">
                            <div class="ContentImageSecond">
                                <img loading="lazy" src="{{ str_contains($row->images,'http')?$row->images:url('storage/app').'/'.strtok($row->images,  ',')}}" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'" class="img-fluid" alt="">
                            </div>
                        
                            <div class="ContentContentSecond">
                                <div class="clientName"><a href="{{url('product-detail/'.$row->id)}}">{{$row->name}}</a></div>
                                <div class="dtrt">{{implode(', ', $category_names)}} · {{($row->product_type!='')?ucfirst($row->product_type):'Used'}} · @if(($row->price != null && is_numeric($row->price) ) && $row->price > 0 && $row->is_rfq == 0)  Buy Now @else RFQ @endif</div>
                                <?php
                                    $price = 0;
                                    $adminCommision = App\Models\AdminCommission::first();

                                    $membership = App\Models\UserMembershipPlan::whereUserId(@$row->user->id)->whereStatus('Active')->latest()->first();

                                    if($row->user && ($row->price != null && is_numeric($row->price) ) && $row->price > 0 && $row->is_rfq == 0){
                                        if($row->user->commission > 0)
                                        {
                                            $commission = $row->price * $row->user->commission / 100;
                                        }elseif($row->user->company && $row->user->company->commission > 0)
                                        {
                                            $commission = $row->price * $row->user->company->commission / 100;
                                        }elseif($membership)
                                        {
                                            $plan = App\Models\SubscriptionPlan::whereName($membership->membership_plan)->first();

                                            if($plan){
                                                $commission = $row->price * $plan->commission / 100;
                                            }else{
                                            $commission = $row->price * $adminCommision->seller_commission / 100;
                                            }
                                        }else{
                                            $commission = $row->price * $adminCommision->seller_commission / 100;
                                        }
                            
                                        $price = ceil($row->price + $commission);
                                    }
                                ?>
                                <div class="TotalProduct"> 
                                    ${{  ($price>0)?number_format($price,2):$price }}   
                                    <a href="javascript:void(0)" onclick="favoriteProduct({{$row->id}})" class="favoritBtns" >
                                        {{-- <i id="favProduct{{$row->id}}" class="fi @if($favProduct) fi-sr-heart @else fi-rr-heart @endif "></i> --}}
                                        @if($favProduct)                            
                                        <div class="favorit-icon favorit-on small favProduct{{$row->id}}"></div>
                                        @else
                                        <div class="favorit-icon favorit-off small favProduct{{$row->id}}"></div>
                                        @endif
                                    </a>         
                                </div>
                                <div class="dtrtDate">
                                    <!-- Expires April 30 2023 -->
                                </div>
                                <div class="reviewCount">
                                     <?php 
                                     if($row->average_rating != null)
                                     {
                                        $number = $row->average_rating;
                                        $average_stars =  ($number * 2) / 2;
                                        $drawn = 5; 
                                        for ($i = 0; $i < floor($average_stars); $i++)
                                        {
                                            $drawn--;
                                            echo '<i class="fas fa-star filled"></i> ';
                                        }
                                        // echo $number - floor($average_stars);
                                        if ($number - floor($average_stars) > 0.5)
                                        {
                                            $drawn--;
                                            echo ' <i class="fas fa-star-half-alt filled"></i> ';
                                        }

                                        for($i = $drawn; $i > 0; $i--)
                                        {
                                            echo ' <i class="far fa-star filled"></i> ';
                                        }
                                    }else{
                                        echo ' <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>';
                                    }

                                      ?>
                                </div>
                                
                                <div class="btnDiv">
                                @if((($row->price != null && is_numeric($row->price) ) && $row->price > 0 && $row->is_rfq == 0) || $row->is_on_sale == true)
                                    <a href="javascript:void(0)" onclick="addToCart({{$row->id}});" class="cartBtns">
                                        <span id="removeCart{{$row->id}}" style={{$style}} > Remove from cart </span>
                                            <span id="cart{{$row->id}}" style={{$nstyle}} > Add to cart </span>
                                    </a> 
                                @else
                                    <a href="{{url('new-rfq', $row->id)}}" class="cartBtns">
                                        <span id="cart{{$row->id}}" style={{$nstyle}} > Request RFQ </span>
                                    </a> 
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach    
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    @include('front-user.pages.inquiry-modal')
</section>

@endsection

@section('script_links')


@endsection

@section('script_codes')
<script>
    // function incrementValue(e) {
    //     e.preventDefault();
    //     var fieldName = $(e.target).data('field');
    //     var parent = $(e.target).closest('div');
    //     var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
    //     newQty = 0;
    //     if (!isNaN(currentVal)) {
    //         newQty = currentVal + 1;
    //         parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
    //     } else {
    //         newQty =  1;
    //         parent.find('input[name=' + fieldName + ']').val(1);
    //     }

    //     $.ajax({
    //             type: "post",
    //             url: "{{ url('/update-cart') }}",
    //             data: {
    //                 "_token": "{{ csrf_token() }}",
    //                 "id": id,
    //                 "qty" : newQty
    //             },
    //             success: function (response) {

    //                 if (response.status == true) {
    //                     toastr.success(response.msg);
    //                 } else {
    //                     toastr.info(response.msg);
    //                 }
    //             }
    //         });
    // }

    // function decrementValue(e) {
    //     e.preventDefault();
        
    //         var fieldName = $(e.target).data('field');
    //         var parent = $(e.target).closest('div');
    //         var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
    //         qty = parseInt(parent.find('input[name=' + fieldName + ']').val());
    //         newQty = 0;
    //         if(qty > 1){
    //             if (!isNaN(currentVal) && currentVal > 0) {
    //                 newQty = currentVal - 1;
    //                 parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
    //             } else {
    //                 newQty = 1;
    //                 parent.find('input[name=' + fieldName + ']').val(1);
    //             }
    //         }

    //         $.ajax({
    //             type: "post",
    //             url: "{{ url('/update-cart') }}",
    //             data: {
    //                 "_token": "{{ csrf_token() }}",
    //                 "id": id,
    //                 "qty" : newQty
    //             },
    //             success: function (response) {

    //                 if (response.status == true) {
    //                     toastr.success(response.msg);
    //                 } else {
    //                     toastr.info(response.msg);
    //                 }
    //             }
    //         });
    // }

   
    $("#addToCart").click(function (e) {
        id = $(this).attr('data-id');
        qty = $('#quantity').val();
        $.ajax({
            type: "post",
            url: "{{ url('/add-to-cart') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "qty" : qty
            },
            success: function (response) {

                if (response.status == true) {
                    cart = '.cartBtns #cart'+id;
                    removeCart = '.cartBtns #removeCart'+id;
                    if(response.cart == false){
                        $(removeCart).hide();
                        $(cart).show();
                    }else{
                        $(removeCart).show();
                        $(cart).hide();
                    }
                    $('#cartCount').text(response.cartCount);
                    toastr.success(response.msg);
                } else {
                    toastr.info(response.msg);
                }
            }
        });
    });


    $(document).ready(function () {    
    
        $('.quantity-field').keypress(function (e) {    

            var charCode = (e.which) ? e.which : event.keyCode    

            if (String.fromCharCode(charCode).match(/[^0-9]/g))    

                return false;                        

        });    

    });
 
    var seo = @json(@$seo);
    if(! seo){
        $(document).ready(function() {
            $(this).attr("title", @json($product->name));
        });
    }
    
</script>
@endsection