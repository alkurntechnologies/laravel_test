@extends('front-user.layouts.dashboard_user')

@section('content')
@php
$imgNotFound = URL::asset('/')."/assets/front-end/images/i-user.png";
@endphp
<style type="text/css">
  #map{ width:700px; height: 500px; }
</style>
<section class="dashboardOuter m-0">
  <div class="row">
    <div class="col-12">
      <div class="dashboardDiv mb-4">
        <div class="dashboardPageTitle">
        Recent Orders
        </div>
      
        <div class="operator-profile customer">
            <div class="table table-responsive">
                @if(count($orders) > 0)
                <table border="0" callpedding="0" cellspecing="0" class="mt-0">
                    <thead>
                        <tr>
                            <th class="brRD">Order Id</th>
                            <th class="brLB">Product</th>
                            <th class="brPR">Quantity</th>
                            <th class="brRD">Price</th>
                            <th class="brRD">Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $orderProduct)
                        <tr>
                            <td>{{$orderProduct->order_number}}</td>
                            
                            <td>@foreach($orderProduct->products as $order)
                            
                            {{$order->product->name}}<br>@endforeach</td>
                            
                            <td> @foreach($orderProduct->products as $order){{$order->quantity}}<br> @endforeach</td>
                            
                            <td> @foreach($orderProduct->products as $order)${{$order->price}}<br>@endforeach</td>
                            
                            
                            <td class="text-nowrap">
                                {{date("m-d-Y", strtotime($orderProduct->created_at))}}
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    No orders yet !
                @endif
            </div>
        </div>
      </div>
    </div>
 
  </div><!-- blogSidebar -->
</section>

@endsection

@section('script_links')

@endsection

@section('script_codes')
            


@endsection