 <!-- <div class="searchTop">
    <div class="listSearch">
        <input type="text" class="form-control search-text" onkeyup="if(event.keyCode===13){$('.search-button').click()}"  name="" id="" aria-describedby="helpId" placeholder="Search">
        <input name="" id="" class="btn btn-primary search-button" type="button" value="Search">
    </div>
    <div class="sort">
        <select class="js-example-basic-single sort_by" name="sort_by">
            <option value="">Sort by</option>
            <option value="rating-desc">Highest Rated</option>
            <option value="rating-asc">Lowest Rated</option>
            <option value="name-asc">A-Z</option>
            <option value="name-desc">Z-A</option> 
        </select>
    </div>
</div>  -->
<div class="products">
    <div id="pageLoader" style="display:none;">
        <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/loading-image.gif" alt="">
        
    </div>
    
    <div id="productList">
        <div class="row productList onlyTable m-0 display-grid" >
            @if(count($products) > 0)
                @foreach($products as $row)
                <?php
                    $style = "display:none";
                    $nstyle = "display:block";
                    $favProduct =  null;
                    if(Auth::check()){
                        if(App\Models\CartDetail::whereUserId(Auth::id())->whereProductId($row->id)->first()){
                            $style = "display:block";
                            $nstyle = "display:none";
                        }

                    }

                ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 d-flex p-0">
                    <div class="productShow">
                        <div class="count-box-second">
                            <a href="{{url('product-detail/'.$row->id)}}">
                                <div class="ContentImageSecond">
                                    @if($row->images)
                                         
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
                                </div>
                            </a>
                        
                            <div class="ContentContentSecond">
                                <div class="TotalProduct">
                                    ${{  ($row->price>0)?number_format($row->price,2):$row->price }}  
                                </div>
                                
                                <div class="reviewCount">
                                    
                                        <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>
                                        <i class="fi fi-sr-star"></i>

                                ?>

                                </div>
                                
                                <div class="btnDiv">
                               
                                    <a href="javascript:void(0)" onclick="addToCart({{$row->id}});" class="cartBtns">
                                        <span id="removeCart{{$row->id}}" style={{$style}} > Remove from cart </span>
                                        <span id="cart{{$row->id}}" style={{$nstyle}} > Add to cart </span>
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else

                <center>Uh-oh! It looks like, there are no products.</center>

            @endif

        </div> 
    </div>
</div>