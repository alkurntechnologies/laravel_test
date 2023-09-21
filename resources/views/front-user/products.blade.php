@extends('front-user.layouts.master_user')

@section('content')
<section class="product-list {{ Request::is('product-spot/rfq_spot') ? 'rfqPage' : '' }} {{ Request::is('product-spot/deal_spot') ? 'deal_spot' : '' }} {{ Request::is('product-spot/shipping_spot') ? 'shipping_spot' : '' }} {{ Request::is('product-spot/shipper_list') ? 'find_shipper' : '' }}">
    <div class="searchTop">
        <div class="container">
            <div class="row m-0">
                <div class="col-12">
                    <div class="intrn">
                        <div class="listSearch">
                            <input type="text" class="form-control search-text" name="" id="searchContent" aria-describedby="helpId" placeholder="Search">
                            <button name="" id="" class="searchSubmit search-button" type="button" value="Search">
                                <svg class="svg-inline--fa fa-magnifying-glass fa-beat-fade fa-2xl" style="color: #fff;" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><g class="fa-duotone-group"><path class="fa-secondary" fill="currentColor" d="M207.1 0C93.12 0-.0002 93.13-.0002 208S93.12 416 207.1 416s208-93.13 208-208S322.9 0 207.1 0zM207.1 336c-70.58 0-128-57.42-128-128c0-70.58 57.42-128 128-128s128 57.42 128 128C335.1 278.6 278.6 336 207.1 336z"></path><path class="fa-primary" fill="currentColor" d="M500.3 443.7l-119.7-119.7c-15.03 22.3-34.26 41.54-56.57 56.57l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7z"></path></g></svg>
                            </button>
                        </div>                         
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            
            <div class="col-md-9 p-0"> 
                @include('front-user.product-list')
            </div>
        </div>
    </div>    
</section>

@endsection

@section('script_links')
@endsection