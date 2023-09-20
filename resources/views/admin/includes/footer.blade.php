<!-- <footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} <a href="http://alkurn.com/" target="_blank">Alkurn Technologies</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
        <b>Alkurn Technologies</b> All rights reserved.
    </div>
</footer> -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery for dismissible-->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>

<script src="{{ URL::asset('/assets/admin/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('/assets/admin/plugins/toastr/toastr.min.js') }}"></script>

<!-- Summernote -->
<script src="{{asset('/assets/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/assets/admin/js/adminlte.js')}}"></script>


<script src="{{asset('/assets/admin/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<!-- <script src="{{URL::asset('/assets/front-end/js/bootstrap-datetimepicker.min.js')}}"></script>
 -->

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="{{ asset('/') }}assets/front-end/js/pignose.calendar.full.min.js"></script>
<script src="{{ asset('/') }}assets/front-end/css/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
@yield('admin_script_links')
@yield('admin_script_codes')

<script type="text/javascript">
   if ($(window).width() < 767) {
        $('body').removeClass('sidebar-collapse');
       
    } else {
        $('body').addClass('sidebar-open');
    }  
    $(".select2").select2();
    
    $(".company-select").select2({
        tags: true
    });
    $(document).ready(function(){
        $('input[type="file"].simpleFile').change(function(e){
            var fileName = e.target.files[0].name;
            $(this).closest(".inputes").find(".inputName").text(fileName);
        });
        $(document).on("click", ".inputName, .custom-button-one", function(){
            $(this).closest(".inputes").find('input[type="file"].simpleFile').click();
        })
        // $(document).on, ".inputName", function(){
        //   $('input[type="file"].simpleFile').click();
        // })
        
    });
    $('.simpleFile').change(function() {
        var file = $(this)[0].files[0].name;
        $(this).closest('.inputes').find(".inputName").text(file);
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        window.Parsley.addValidator('fileextension', function (value, requirement) {
            var fileExtension = value.split('.').pop();

            return requirement.includes(fileExtension.toLowerCase());
        }, 32)
            .addMessage('en', 'fileextension', 'Please upload only jpg/png file.');
    });
    

    //<![CDATA[
    $(function() {
        const date = new Date();
        date.setDate(date.getDate() - 1);
        function onClickHandler(date, obj) {
            /**
             * @date is an array which be included dates(clicked date at first index)
             * @obj is an object which stored calendar interal data.
             * @obj.calendar is an element reference.
             * @obj.storage.activeDates is all toggled data, If you use toggle type calendar.
             * @obj.storage.events is all events associated to this date
             */

            var $calendar = obj.calendar;
            var $box = $('#shipmentDate');
            var text = "";
            var text_show = "";

            if(date[0] !== null) {
                text += date[0].format('YYYY-MM-DD');
                text_show += date[0].format('MM-DD-YYYY');
            }

            // if(date[0] !== null && date[1] !== null) {
            //     text += ' ~ ';
            // } else if(date[0] === null && date[1] == null) {
            //     text += 'nothing';
            // }

            // if(date[1] !== null) {
            //     text += date[1].format('YYYY-MM-DD');
            // }
            // alert($(this).closest(".date").find(".selectDate").name())
            $(this).closest(".date").find(".selectDate").val(text_show);
            $(this).closest(".date").find(".inputHidden").val(text);
            $('.calendar').hide();
        }

        
        $('.calendar').pignoseCalendar({
            select: onClickHandler,
            minDate: date,
        });


        // $('.calendar').pignoseCalendar({
        //     select: onClickHandler,
        //     minDate: date,
        //     click: function(context) {
        //         var  $str = $('#shipment_date').val();
        //         if($str != ''){
        //             var  $date = new Date($str);
        //             var $mnth = ("0" + ($date.getMonth() + 1)).slice(-2);
        //             var $day = ("0" + $date.getDate()).slice(-2);
        //             var $newDate = [$date.getFullYear(), $mnth, $day].join("-");
        //             // if($newDate != 'NaN-aN-aN'){
        //             //     $('#shipmentDate').val($newDate);
        //             // }
        //             // alert($date.getFullYear()+'-'+$mnth+'-'+$day)
        //             $('#shipmentDate').val($date.getFullYear()+'-'+$mnth+'-'+$day);
        //         }

        //         var  $str_pickup = $('#shipment_pickup_date').val();
        //         if($str_pickup != ''){
        //             var  $date = new Date($str_pickup);
        //             var $mnth = ("0" + ($date.getMonth() + 1)).slice(-2);
        //             var $day = ("0" + $date.getDate()).slice(-2);
        //             var $newDate = [$date.getFullYear(), $mnth, $day].join("-");
        //             // if($newDate != 'NaN-aN-aN'){
        //             //     $('#shipmentDate').val($newDate);
        //             // }
        //             // alert($date.getFullYear()+'-'+$mnth+'-'+$day)
        //             $('#shipmentPickupDate').val($date.getFullYear()+'-'+$mnth+'-'+$day);
        //         }

        //         var  $str_delivery = $('#shipment_delivery_date').val();
        //         if($str_delivery != ''){
        //             var  $date = new Date($str_delivery);
        //             var $mnth = ("0" + ($date.getMonth() + 1)).slice(-2);
        //             var $day = ("0" + $date.getDate()).slice(-2);
        //             var $newDate = [$date.getFullYear(), $mnth, $day].join("-");
        //             // if($newDate != 'NaN-aN-aN'){
        //             //     $('#shipmentDate').val($newDate);
        //             // }
        //             // alert($date.getFullYear()+'-'+$mnth+'-'+$day)
        //             $('#shipmentDeliveryDate').val($date.getFullYear()+'-'+$mnth+'-'+$day);
        //         }
        //     },
            


        // });



        $('.selectDate').keyup(function(){
            console.log(1)
            setTimeout(function () {
                var  $str = $('#shipment_date').val();
                if($str != ''){
                    var  $date = new Date($str);
                    var $mnth = ("0" + ($date.getMonth() + 1)).slice(-2);
                    var $day = ("0" + $date.getDate()).slice(-2);
                    $('#shipmentDate').val($date.getFullYear()+'-'+$mnth+'-'+$day);
                }
                
                var  $str_pickup = $('#shipment_pickup_date').val();
                if($str_pickup != ''){
                    var  $date = new Date($str_pickup);
                    var $mnth = ("0" + ($date.getMonth() + 1)).slice(-2);
                    var $day = ("0" + $date.getDate()).slice(-2);
                    var $newDate = [$date.getFullYear(), $mnth, $day].join("-");
                    // if($newDate != 'NaN-aN-aN'){
                    //     $('#shipmentDate').val($newDate);
                    // }
                    // alert($date.getFullYear()+'-'+$mnth+'-'+$day)
                    $('#shipmentPickupDate').val($date.getFullYear()+'-'+$mnth+'-'+$day);
                }

                var  $str_delivery = $('#shipment_delivery_date').val();
                if($str_delivery != ''){
                    var  $date = new Date($str_delivery);
                    var $mnth = ("0" + ($date.getMonth() + 1)).slice(-2);
                    var $day = ("0" + $date.getDate()).slice(-2);
                    var $newDate = [$date.getFullYear(), $mnth, $day].join("-");
                    // if($newDate != 'NaN-aN-aN'){
                    //     $('#shipmentDate').val($newDate);
                    // }
                    // alert($date.getFullYear()+'-'+$mnth+'-'+$day)
                    $('#shipmentDeliveryDate').val($date.getFullYear()+'-'+$mnth+'-'+$day);
                }
            }, 2000)
                
        });

        // This use for DEMO page tab component.
    });
    //]]>

    var now = Date.now();
    $(document).on("click", ".date", function(){
        $(this).find('.calendar').show();
    })

    // window.onload = function(){
    //     var hideMe = document.getElementsByClassName('calendar');
    //     document.onclick = function(e){
    //        if(e.target.id !== 'hideMe'){
    //           hideMe.style.display = 'none';
    //        }
    //     };
    //  };
        $(document).mouseup(function (e) {
        if ($(e.target).closest(".calendar").length
                    === 0) {
            $(".calendar").hide();
        }
    });

     /**
   * productImage slider
   */
   new Swiper('.swiper-order', {
        speed: 400,
        loop: true,
        autoplay: false,
        slidesPerView: 'auto',
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: '.swiper-pagination',
        paginationClickable: true,
      });


$('#exampleModal').on('shown.bs.modal', function (event) {
    $("#cardNumber").on('keyup', function(){
        cardValidate(this);
    })
    
    $(document).on("click",".linkCard", function(){
        $(this).addClass("active");
        $(".linkstripe").removeClass("active");
        $(".cardDiv").show();
        $(".sripeDiv").hide();
        $('#paymentVia').val('card');
        $('#accountName').removeAttr('required');
        $('#accountNumber').removeAttr('required');
        $('#routingNumber').removeAttr('required');
        $('#phoneNumber').removeAttr('required');
        $('#account_type').removeAttr('required');
        $('#fullname1').attr('required','');
        $('#cardNumber').attr('required','');
        $('#expiry').attr('required','');
        $('#cvv').attr('required','');
        $('#zipcode').attr('required','');
    
    });
    $(document).on("click",".linkstripe", function(){
        $(this).addClass("active");
        $(".linkCard").removeClass("active");
        $(".cardDiv").hide();
        $(".sripeDiv").show();
        $('#paymentVia').val('ach_account')
        $('#fullname1').removeAttr('required');
        $('#cardNumber').removeAttr('required');
        $('#expiry').removeAttr('required');
        $('#cvv').removeAttr('required');
        $('#zipcode').removeAttr('required');
        $('#accountName').attr('required', '');
        $('#accountNumber').attr('required', '');
        $('#routingNumber').attr('required', '');
        $('#phoneNumber').attr('required', '');
        $('#account_type').attr('required', '');
    });

    $(".sripeDiv").hide();
    $('#masterCard').hide();
    $('#jcb').hide();
    $('#dinnerClub').hide();
    $('#discover').hide();
    $('#amex').hide();
    $('#visa').hide();
    function cardValidate(ccnum){
            $('#masterCard').hide();
            $('#jcb').hide();
            $('#dinnerClub').hide();
            $('#discover').hide();
            $('#amex').hide();
            $('#visa').hide();
            var cardNo = ccnum.value;
            var masterCardRegex=/^(?:5[1-5][0-9]{14})$/;
            var visaCardRegex=/^(?:4[0-9]{12})(?:[0-9]{3})$/;
            var americanExpCardRegex=/^(?:3[47][0-9]{13})$/;
            var discoverRegex = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/
            var jcbRegex = /^(?:(?:2131|1800|35\d{3})\d{11})$/;
            var dinnerRegex = /^(?:3(?:0[0-5]|[68][0-9])[0-9]{11})$/;

            var cardName="-";
            if(masterCardRegex.test(cardNo)){
                cardName="Master Card";
            }else if(visaCardRegex.test(cardNo)){
                cardName="Visa Card";
            }else if(americanExpCardRegex.test(cardNo)){
                cardName="American Express Card";
            }else if(discoverRegex.test(cardNo)){
                cardName="Discover Card";
            }else if(jcbRegex.test(cardNo)){
                cardName="JCB Card";
            }else if(dinnerRegex.test(cardNo)){
                cardName="Diners Club Card";
            }

            if(cardName == 'Master Card'){
                $('#masterCard').show();
                // $('#masterCard').hide();
                $('#jcb').hide();
                $('#dinnerClub').hide();
                $('#discover').hide();
                $('#amex').hide();
                $('#visa').hide();
            }else if(cardName == 'American Express Card'){
                $('#amex').show();
                $('#masterCard').hide();
                $('#jcb').hide();
                $('#dinnerClub').hide();
                $('#discover').hide();
                // $('#amex').hide();
                $('#visa').hide();
            }else if(cardName == 'Discover Card'){
                $('#discover').show();
                $('#masterCard').hide();
                $('#jcb').hide();
                $('#dinnerClub').hide();
                // $('#discover').hide();
                $('#amex').hide();
                $('#visa').hide();
            }else if(cardName == 'JCB Card'){
                $('#jcb').show();
                $('#masterCard').hide();
                // $('#jcb').hide();
                $('#dinnerClub').hide();
                $('#discover').hide();
                $('#amex').hide();
                $('#visa').hide();
            }else if(cardName == 'Diners Club Card'){
                $('#dinnerClub').show();
                $('#masterCard').hide();
                $('#jcb').hide();
                // $('#dinnerClub').hide();
                $('#discover').hide();
                $('#amex').hide();
                $('#visa').hide();
            }else if(cardName == 'Visa Card'){
                $('#visa').show();
                $('#masterCard').hide();
                $('#jcb').hide();
                $('#dinnerClub').hide();
                $('#discover').hide();
                $('#amex').hide();
                // $('#visa').hide();
            }

            // document.querySelector("#out").innerText=cardName;
        }
        $('#expiry').mask('00/0000');

    }) 

    $(document).on("click", '.changeStatus', function() { 
        $('#id').val($(this).data("id")); 
        $('#response_id_new').val($(this).data("response-id")); 
    }); 
    $(document).on("click", '.StatusProduct', function() {
        $('#product_id').val($(this).data("id")); 
        $('#response_id').val($(this).data("response-id")); 
    }); 

    $(document).on("click", '.exampleModalPay', function() {
        id = $(this).data('id')
        amount = $('#shippingCost'+id).val();
        commission = $('#shippingCommission'+id).val();
        $('#amount').val(amount);
        $('#commission').val(commission);
        $('#rfqRequestId').val($('#rfq'+id).val());
        $('#totalPay').text('($'+amount+')');
  }); 
</script>

</body>
</html>
