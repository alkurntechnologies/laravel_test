@extends('front-user.layouts.dashboard_user')
@section('title')
    {{config('app.name')}} | Notifications
@endsection

@section('content')
<section class="dashboardOuter m-0">
  <div class="row">
    <div class="col-12">
      <div class="dashboardDiv mb-4">
        <div class="dashboardPageTitle">
        Notifications
        </div>
      
        <div class="operator-profile customer">
                
                @if(count($notifications) > 0)
                @php 
                  //convert from my timezone and save in UTC
                  if (strpos(url('/'),'localhost') !== false || strpos(url('/'),'192.168.43.223') !== false) { 
                      $user_ip = "103.73.215.170";
                  }else{
                      $user_ip = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1';
                  }
                        
                  $get_data = file_get_contents("http://ip-api.com/json/".$user_ip."?fields=status,message,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,currency,isp,org,as,query");
                  $get_data = json_decode($get_data,true);
              @endphp
                          @foreach($notifications as $i => $notification)
                            @php 
                          

                            if($notification->created_at!='')
                            {
                                $notification->created_at = \DateTime::createFromFormat('Y-m-d H:i:s',$notification->created_at,new \DateTimeZone($get_data['timezone']));
                                $notification->created_at->setTimeZone(new \DateTimeZone('UTC'));
                            }
                            $notification_date_time = \DateTime::createFromFormat('Y-m-d H:i:s',$notification->created_at,new \DateTimeZone('UTC'));
                            $dateTime = $notification_date_time->setTimeZone(new \DateTimeZone($get_data['timezone']));  
                        @endphp
                          <div class="samestyle">
                            <div class="dashboardListssw">{{$dateTime->format('M d, Y')}} | {{$dateTime->format('H:i A')}}
                            </div>
                                @if(@$notification->data['link'] == "")
                                    <a class="notification">{{ isset($notification->data)?@$notification->data['msg']:''}}</a>  
                                @else
                                    <a class="notification">{{$notification->data['msg']}}</a>
                                    <a href="{{$notification->data['link']}}" class="downloadIcon showDetail ms-auto"><i class="fas fa-eye    "></i></a>
                                @endif
                          </div>
                          @endforeach
                @else             
                No notifications yet
                @endif
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
@endsection