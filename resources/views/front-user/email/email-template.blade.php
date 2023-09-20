<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
    <body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; background-color: #eff4f8; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 20px; width: 100% !important;"
        data-new-gr-c-s-check-loaded="14.1026.0" data-gr-ext-installed="">
        <style>
            @font-face {
                font-family: 'Ayar';
                src: url('{{ asset('/') }}assets/front-end/fonts/Ayar.eot');
                src: url('{{ asset('/') }}assets/front-end/fonts/Ayar.eot?#iefix') format('embedded-opentype'),
                    url('{{ asset('/') }}assets/front-end/fonts/Ayar.woff2') format('woff2'),
                    url('{{ asset('/') }}assets/front-end/fonts/Ayar.woff') format('woff'),
                    url('{{ asset('/') }}assets/front-end/fonts/Ayar.ttf') format('truetype'),
                    url('{{ asset('/') }}assets/front-end/fonts/Ayar.svg#Ayar') format('svg');
                font-weight: normal;
                font-style: normal;
                font-display: swap;
            }
        </style>
        <table border="0" cellpadding="0" cellspacing="0" style="font-family: 'Ayar';max-width: 889px;margin:0 auto;padding: 40px  29px;width: 1000%;">    
            <tbody>        
                <tr>            
                    <td style="padding: 40px 29px;">                
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">                    
                            <tbody>
                                <tr>
                                    <td style="font-family: 'Ayar';max-width900px;margin:0 auto;">
                                        <strong>E-RAILSPOT</strong>
                                        <p style="margin: 0;font-size: 12px;line-height: 18px;margin-top: 11px;">
                                            14090 Southwest Fwy<br>
                                            Sugar Land, TX 77478 US<br>
                                            +1 2813823321<br>
                                            tim@e-railspot.com<br>
                                            https://e-railspot.com<br>
                                        </p>
                                    </td>
                                    <td
                                        style="font-family: 'Ayar';max-width900px;margin:0 auto;vertical-align: middle; text-align:right">
                                        <img src="https://e-railspot.com/assets/front-end/images/new-logo-black.png"
                                            style="width: 209px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;margin-top: 33px;vertical-align: top;">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="font-family: 'Ayar';margin:0 auto;color: #d4273b;font-size: 20px;padding-bottom: 11px;">
                                        Purchase Order
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;font-size: 15px;line-height: 22px;">
                                        <p style="font-family: 'Ayar';margin:0 auto;color: #a895b3;">
                                            VENDOR
                                        </p>
                                        <p style="font-family: 'Ayar';margin:0 auto;">{{$seller_rfq_respond->user->first_name}} {{$seller_rfq_respond->user->last_name}}<br>
                                        {{$seller_rfq_respond->user->company_name}}<br>
                                            {{$seller_rfq_respond->user->billing_address}}
                                        </p>
                                    </td>
                                    <td style="vertical-align: top;font-size: 15px;line-height: 22px;">
                                        <p style="font-family: 'Ayar';margin: 0 auto;color: #a895b3;">
                                            SHIP TO</p>
                                        <p style="font-family: 'Ayar';max-width900px;margin:0 auto;">
                                        {{$rfqData->user->first_name}} {{$rfqData->user->last_name}}<br>
                                        {{$rfqData->user->company_name}}<br>
                                            {{$rfqData->user->billing_address}}
                                        </p>
                                    </td>
                                    <td style="vertical-align: text-bottom;vertical-align: top;font-size: 15px;line-height: 22px;width: 156px;">
                                        <p style="font-family: 'Ayar';max-width900px;margin:0 auto;">
                                            <span style="font-family: 'Ayar';margin: 0 auto;color: #a895b3;display: inline-block;width: 78px;">P.O.</span>{{$seller_rfq_respond->po_no}}
                                        </p>
                                        <p style="font-family: 'Ayar';max-width900px;margin:0 auto;">
                                            <span style="font-family: 'Ayar';margin: 0 auto;color: #a895b3;width: 78px;display: inline-block;">DATE</span>{{ date('m-d-Y', strtotime($seller_rfq_respond->po_date)) }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: 'Ayar';margin: 21px auto 0;width: 100%;text-align: left;vertical-align: top;border-bottom: dashed  1px #babec5;">
                            <thead style="background: #f6d4d7;color: d63441;font-size: 14px;">
                                <tr>
                                    <th style="padding: 7px 6px;color: #d73c4b;">ACTIVITY</th>
                                    <th style="padding: 7px 6px;color: #d73c4b;">DESCRIPTION</th>
                                    <th style="text-align: right;padding: 7px 6px;color: #d73c4b;">QTY</th>
                                    <th style="text-align: right;padding: 7px 6px;color: #d73c4b;">RATE</th>
                                    <th style="text-align: right;padding: 7px 6px;color: #d73c4b;">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($seller_rfq_respond->product)
                                    @php 
                                    $product = $seller_rfq_respond->product;
                                    $rfqProduct = App\Models\RfqProducts::whereSellerRfqRespondId($seller_rfq_respond->id)->whereProductId($product->id)->first(); 
                                    $productCommission = $seller_rfq_respond->commission / $product->quantity;
                                    $total = 0;
                                    @endphp
                                    <tr>
                                        <td style="padding: 9px 6px;width: 150px;vertical-align: top;line-height: 18px;">
                                            Products:{{$product->name}}
                                        </td>
                                        <td style="padding: 9px 6px;vertical-align: top;line-height: 18px;">{{$product->description}}</td>
                                        <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">{{$product->quantity}}</td>
                                        <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">{{number_format($rfqProduct->unit_price + $productCommission, 2)}}
                                        </td>
                                        <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">{{number_format($rfqProduct->price + $seller_rfq_respond->commission, 2)}}
                                        </td>
                                    </tr>
                                    @php $total+= $rfqProduct->price + $seller_rfq_respond->commission; @endphp
                                @else
                                    @php $qty = 0; @endphp
                                    @foreach($rfqData->products as $key => $product)
                                    @php 
                                        if($product->quantity > 1){
                                            $qty += $product->quantity;
                                        }
                                        if($qty > 0){
                                            $productCommission = $seller_rfq_respond->commission / $qty;
                                        }

                                    @endphp
                                    @endforeach
                                    @foreach($rfqData->products as $product)
                                        @php 
                                        $rfqProduct = App\Models\RfqProducts::whereSellerRfqRespondId($seller_rfq_respond->id)->whereProductId($product->id)->first(); 
                                        $total = 0;
                                        @endphp
                                    <tr>
                                        <td style="padding: 9px 6px;width: 150px;vertical-align: top;line-height: 18px;">
                                            Products:{{$product->name}}
                                        </td>
                                        <td style="padding: 9px 6px;vertical-align: top;line-height: 18px;">{{$product->description}}</td>
                                        <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">{{$product->quantity}}</td>
                                        <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">${{number_format($rfqProduct->unit_price + $productCommission, 2)}}
                                        </td>
                                        <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">${{number_format($rfqProduct->price + ($productCommission * $product->quantity), 2)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @php $total = $seller_rfq_respond->final_price + $seller_rfq_respond->commission; @endphp

                                @endif
                                <!-- <tr>
                                    <td style="padding: 9px 6px;vertical-align: top;line-height: 18px;">Products:Freight</td>
                                    <td style="padding: 9px 6px;vertical-align: top;line-height: 18px;">Freight</td>
                                    <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">1</td>
                                    <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">120.00
                                    </td>
                                    <td style="text-align: right;padding: 9px 6px;vertical-align: top;line-height: 18px;">120.00
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: 'Ayar';max-width900px;margin: 45px auto 0;width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="font-size: 12px;color: #abb2b7;">
                                        Please provide tracking information for QTY 9 shipped to Laredo TX
                                    </td>
                                    <td style="color: #abb2b7;">
                                        TOTAL
                                    </td>
                                    <td style="text-align: right;">
                                        USD {{number_format($total, 2)}}
                                    </td>
                                </tr>                   
                            </tbody>                
                        </table> 
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: 'Ayar';max-width900px;margin: 45px auto 0;width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 133px;">
                                        <p style="margin: 0;color: #abb2b7;font-size: 14px;width: 133px;">
                                            Approved By</p>
                                    </td>
                                    <td style="border-bottom: solid 1px #8d9096;">
                                        <p style="width: 100%;">{{$rfqData->user->first_name}} {{$rfqData->user->last_name}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="margin: 0;width: 133px;margin: 0;color: #abb2b7;font-size: 14px;width: 133px;padding-top: 28px;">
                                        Date</p>
                                    </td>
                                    <td style="border-bottom: solid 1px #8d9096;padding-top: 28px;">
                                        <p>{{date('m-d-Y')}}</p>
                                    </td>
                                </tr>                    
                            </tbody>                
                        </table>            
                    </td>
                </tr>     
                    
            </tbody>
        </table>
    </body>
</html>