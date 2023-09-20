<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
	<table align="center" cellpadding="0" cellspacing="0" role="presentation"
		style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff">
		<tr class="">
			<td style=" padding-bottom:30px;">
				<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;font-weight:700;background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;text-transform:uppercase;padding-bottom:10px;">e-railspot</p>
				<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;width:200px">
						14090 Southwest Fwy Sugar Land, TX 77478<br />
						US
				</p>
				<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;">
					+1 2813823321
				</p>
				<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;">
					tim@e-railspot.com
				</p>
				<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;">
					{{url('/')}}
				</p>
			</td>
			<td style="vertical-align: top; padding-bottom:30px;">
				<a href="{{ url('/') }}" style="display:inline-block;text-decoration: none;float:right;">
					<img loading="lazy" src="{{public_path('assets/front-end/images/new-logo-black.png')}}" alt="BTS" style="width:202px;">
				</a>
			</td>
		</tr>
    </table>
	<table border=0 cellpadding="0" cellspacing="0" role="presentation" style="font-size: 15px;width: 100%;">
		<tr>
			<td style="width:70%;">
				<table border=0 cellpadding="0" cellspacing="0" style="width:100%;">
					<tr>
						<td style="width:50%; border-bottom:solid 3px #c60000;">
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-weight:700;background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;padding-bottom:10px;">BILL TO</p>
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;width:200px">
								{{@$order->user->first_name.' '.@$order->user->last_name}}
							</p>
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;">
								<a href="mailto:{{@$order->user->email}}" style="color: #4E4D4D;text-decoration: none;margin-bottom: 5px;
									display: inline-block;">{{@$order->user->email}}</a>
							</p>
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;">
								<a href="tel:{{@$order->user->phone}}" style="color: #4E4D4D;text-decoration: none;margin-bottom: 5px;
									display: inline-block;">{{@$order->user->phone}}</a>
							</p>
						</td>
						<td style="width:50%; border-bottom:solid 3px #c60000;">
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-weight:700;background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;padding-bottom:10px;">SHIP TO</p>
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;width:200px">
								{{@$order->user->first_name.' '.@$order->user->last_name}}<br/>
							</p>
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;">
								<a href="mailto:{{@$order->user->email}}" style="color: #4E4D4D;text-decoration: none;margin-bottom: 5px;
									display: inline-block;">{{@$order->user->email}}</a>
							</p>
							<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%;background:#ffffff;color: #4E4D4D;padding-bottom:5px;font-size:14px;">
								<a href="tel:{{@$order->user->phone}}" style="color: #4E4D4D;text-decoration: none;margin-bottom: 5px;
									display: inline-block;">{{@$order->user->phone}}</a>
							</p>
						</td>
					</tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<p style="background:#c60000; color:#ffffff;margin:0 0 5px 20px;padding:5px 15px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';">
					Invoice: {{$order->order_number}}
				</p>
				<p style="background:#c60000; color:#ffffff;margin:0 0 5px 20px;padding:5px 15px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';">
					Order Date: {{date('m-d-Y',strtotime(@$order->order_date))}}
				</p>
			</td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0" border=0 style="width: 100%; " align="center">
		<tr>
			<td style="font-family: Montserrat;font-size: 14px; color: #4E4D4D;border-bottom:1px solid #ddd;padding-top:50px">
				<table cellpadding="0" cellspacing="0" border=0 width="100%">		
					<thead>
						<tr>
							<th style="font-family: Montserrat;font-size: 14px; color: #fff;background-color: #c60000; padding:10px 15px; vertical-align: top;padding-left: 30px;text-align:left;border-bottom:solid 2px #ddd;">
								S.N.
							</th>
							<th style="font-family: Montserrat;font-size: 14px; color: #fff;background-color: #c60000; padding:10px 15px; vertical-align: top;padding-left: 30px;text-align:left;border-bottom:solid 2px #ddd;">
							Name
							</th>
                            <th style="font-family: Montserrat;font-size: 14px; color: #fff;background-color: #c60000; padding:10px 15px; vertical-align: top;padding-left: 30px;text-align:left;border-bottom:solid 2px #ddd;">
                                Description
                            </th>
							<th style="font-family: Montserrat;font-size: 14px; color: #fff;background-color: #c60000; padding:10px 15px; vertical-align: top;padding-left: 30px;text-align:right;border-bottom:solid 2px #ddd;">
							Quantity
							</th>
							<th style="font-family: Montserrat;font-size: 14px; color: #fff;background-color: #c60000; padding:10px 15px; vertical-align: top;padding-left: 30px;text-align:right;border-bottom:solid 2px #ddd;">
							Item Total
							</th>
						</tr>
					</thead>
					@foreach($order->products as $key => $product)
					<?php 
                        if($product->product){
                                $name =  $product->product->name;
                        }else{
                                $products = explode(',',$product->auctionLot->product_ids);
                                $product_names = [];
                        
                                foreach($products as $id)
                                {
                                $lot_product = App\Models\Product::find($id);
                        
                                if($lot_product){
                                        $product_names [] = $lot_product->name;
                                }
                                }
                                $name = implode(',', $product_names);
                        }
                     ?>
					<tr>
						<td  style="font-family: Montserrat;font-size: 14px; color: #4E4D4D;vertical-align: top;padding:10px 15px;padding-left: 30px;">
							{{$key+1}}
						</td>
						<td  style="font-family: Montserrat;font-size: 14px; color: #4E4D4D;vertical-align: top;padding:10px 15px;padding-left: 30px;font-weight:700;">
							{{$name}}
						</td>
                        <td style="font-family: Montserrat;font-size: 14px; color: #4E4D4D;vertical-align: top;padding:10px 15px;padding-left: 30px;">
						{{$product->product ? $product->product->description : $product->auctionLot->description}}
                        </td>
						<td  style="font-family: Montserrat;font-size: 14px; color: #4E4D4D;vertical-align: top;padding:10px 15px;padding-left: 30px;text-align:right;">
							{{$product->quantity}}
						</td>
						<td  style="font-family: Montserrat;font-size: 14px; color: #4E4D4D;vertical-align: top;padding:10px 15px;padding-left: 30px;text-align:right;font-weight:600;">
							${{$product->item_total}}
						</td>
					</tr>
					@endforeach
					
				</table>
			</td>
		</tr>
		<tr>
            <td>
                <table cellpadding="0" cellspacing="0" border=0  style="width:100%; margin-top: 70px;">
                    <tr>
                        <td style="width: 70%;">
                        </td>
                        <td>
                            <table cellpadding="0" cellspacing="0" border=0  style="width:100%">
                                <tr>
                                    <td  style="font-family: Montserrat;font-size: 14px; color: #c60000;vertical-align: top;padding:10px 10px;">
                                        Total Tax
                                    </td>
                                    <td  style="font-family: Montserrat;font-size: 14px; color: #4E4D4D;vertical-align: top;padding:10px 10px;text-align:right;font-weight:600;">
                                        ${{$order->taxes}}
                                    </td>
                                </tr>
                                <tr>                        
                                    <td  style="font-family: Montserrat;font-size: 14px; color: #ffffff; background-color: #c60000; vertical-align: top;padding:10px 10px;">
                                        Grand Total
                                    </td>
                                    <td  style="font-family: Montserrat;font-size: 14px; color: #ffffff; background-color: #c60000; vertical-align: top;padding:10px 10px;text-align:right; font-weight:600;">
                                        ${{$order->total}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
		<tr>
			<td style="font-family: Montserrat;font-size: 12px;color: #4E4D4D;text-align: center;padding-top:30px;">
				<p style="text-align: center; width: 100%; margin:0;display: inline-block;"><a href="{{ url('/') }}" style="color: #0032A0;text-decoration: none;">E-Railspot</a></p><br><br>
			</td>
		</tr>
</table>