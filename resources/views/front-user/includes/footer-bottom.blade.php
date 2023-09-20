<div id="overlay1">
    <!-- <div class="loaderContent">This can take up to 90 seconds</div> -->
    <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/loading-image.gif" id="loading-image" alt="">
</div>
    <!-- Vendor JS Files -->
<script src="{{ asset('/') }}assets/front-end/css/purecounter/purecounter.js"></script>
<script src="{{ asset('/') }}assets/front-end/css/aos/aos.js"></script>
{{-- <script src="{{ asset('/') }}assets/front-end/css/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('/') }}assets/front-end/css/glightbox/js/glightbox.min.js"></script>
<script src="{{ asset('/') }}assets/front-end/css/isotope-layout/isotope.pkgd.min.js"></script>
<script src="{{ asset('/') }}assets/front-end/css/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('/') }}assets/front-end/css/php-email-form/validate.js"></script>
<!-- <script src="{{ asset('/') }}assets/front-end/js/bootstrap-datepicker.js"></script> -->
<script src="{{ asset('/') }}assets/front-end/js/toast.js"></script>
<script src="{{ asset('/') }}assets/front-end/js/toasteur.min.js"></script>

<script src="{{ URL::asset('/assets/admin/plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Template Main JS File --> 
<script src="{{ asset('/') }}assets/front-end/css/main.js"></script> 
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<!-- New calender js -->
<script type="text/javascript" src="{{ asset('/') }}assets/front-end/js/pignose.calendar.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
    $(document).ready(function(){
        $('.js-example-basic-single').select2();
        
    })

    $(document).on("click",".toggle-password", function(){
        if($(this).closest(".form-group").find(".password").attr("type") == "password"){
            $(this).closest(".form-group").find(".password").attr('type', 'text')
            $(this).addClass("checked");
        } else {
            $(this).closest(".form-group").find(".password").attr('type', 'password')
            $(this).removeClass("checked");
        }
        
    })

    
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



    $(document).on("click",".getSearch", function(){
        $('#searchForm').submit();
    })

    function addToCart(id)
    {
        $.ajax({
            type: "post",
            url: "{{ url('/add-to-cart') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
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

                    var url = '{{url("checkout")}}';
                    if(response.cartId){
                        setTimeout(function () {
                            window.location.href=url +'/'+response.cartId;
                        }, 2000)
                    }
                  
                } else {
                    toastr.info(response.msg);
                }
            }
        });
    }

    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
        newQty = 0;
     
        if (!isNaN(currentVal)) {
            newQty = currentVal + 1;
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            newQty =  1;
            parent.find('input[name=' + fieldName + ']').val(1);
        }

        $.ajax({
                type: "post",
                url: "{{ url('/update-cart') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "qty" : newQty
                },
                success: function (response) {

                    if (response.status == true) {
                        // toastr.success(response.msg);
                        price = $('#cartTopPrice'+id).attr('data-price');
                        // shipping =  $('#shippingCost'+id).val();
                        $('#originalAmount').val(total);

                        total = response.total;
                        total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        productPrice = parseFloat(price) * parseInt(newQty);
                        $('#cartTopPrice'+id).text('$'+productPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#subTotal').text('$'+total);
                        $('#total').text('$'+total);
                        $('#totalPay').text('($'+total+')');
                    } else {
                        toastr.info(response.msg);
                    }
                }
            });
    }

    function decrementValue(e) {
        e.preventDefault();
        
            var fieldName = $(e.target).data('field');
            var parent = $(e.target).closest('div');
            var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
            qty = parseInt(parent.find('input[name=' + fieldName + ']').val());
            newQty = 0;
            if(qty > 1){
                if (!isNaN(currentVal) && currentVal > 0) {
                    newQty = currentVal - 1;
                    parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
                } else {
                    newQty = 1;
                    parent.find('input[name=' + fieldName + ']').val(1);
                }

                $.ajax({
                    type: "post",
                    url: "{{ url('/update-cart') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "qty" : newQty
                    },
                    success: function (response) {

                        if (response.status == true) {
                            // toastr.success(response.msg);
                            price = $('#cartTopPrice'+id).attr('data-price');
                            // shipping =  $('#shippingCost'+id).val();
                            $('#originalAmount').val(total);

                            total = response.total;
                            total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            productPrice = parseFloat(price) * parseInt(newQty);
                            $('#cartTopPrice'+id).text('$'+productPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#subTotal').text('$'+total);
                            $('#total').text('$'+total);
                            $('#totalPay').text('($'+total+')');
                        } else {
                            // toastr.info(response.msg);
                        }
                    }
                });
            }

    }

    $('.input-group').on('click', '.button-plus', function(e) {
        id = $(this).attr('id');
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
    
        if (isNaN(currentVal)) {
            $('.button-plus'+id).attr('disabled', '');
        }else{
            incrementValue(e, id);
        }
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        id = $(this).attr('id');
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
     
        if (isNaN(currentVal)) {
            $('.button-plus'+id).removeAttr('disabled', '');
        }
        
        decrementValue(e, id);
    });
    $(document).on('keyup','#text',function(e){
        if($('#text').val()!='' || $('#file-upload')[0].files[0]!=undefined)
        $("#sendMsgBtn").attr('disabled',false);
        else
        $("#sendMsgBtn").attr('disabled','disabled');

        // if (e.which == 13) {
        //     $('#replyMessage').submit();
        // }
    });
    $(document).on('click','.closechat',function(){
        $('#chat-box').hide();
    })

        var base_url = '{{ url("/") }}';
        var csrf = '{{ csrf_token() }}'
</script>
<script type="text/javascript">
  $(function() {
     $("#file-upload").change(function (){
       var fileName = $(this).val();
       if(fileName != ""){
            $(this).prev(".custom-file-upload").addClass("select-file")
            $(this).next().addClass("select-file")
       }
     });
  });

</script>
<!-- New calender -->
<script type="text/javascript">
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
    const swiper = new Swiper('.swiper-slide', {
        // Default parameters
        slidesPerView: 1,
        spaceBetween: 10,
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
            slidesPerView: 2,
            spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
            slidesPerView: 3,
            spaceBetween: 30
            },
            // when window width is >= 640px
            640: {
            slidesPerView: 4,
            spaceBetween: 40
            }
        }
    })
    $(document).ready(function(){
        // $("#myModal").modal('show');
        $('.simpleFile').change(function() {
            var file = $(this)[0].files[0].name;
            $(this).closest('.inputes').find(".inputName").text(file);
        });
        $(document).on("click", ".listView", function(){
            $(this).addClass("active")
            $(".gridView").removeClass("active")
            $(".productList").addClass("display-list").removeClass("display-grid");
            $(".productList > .col-lg-4.col-md-6.col-12.d-flex.p-0").removeClass("col-lg-4 col-md-6 col-sm-6").addClass("");
        })
        $(document).on("click", ".gridView", function(){
            $(this).addClass("active")
            $(".listView").removeClass("active")
            $(".productList").removeClass("display-list").addClass("display-grid");
            $(".productList > .col-12.d-flex.p-0").addClass("col-lg-4 col-md-6 col-sm-6");
        })
    });






    $(document).ready(function() {
        var bigimage = $("#big");
        var thumbs = $("#thumbs");
        //var totalslides = 10;
        var syncedSecondary = true;

        bigimage
            .owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: false,
            autoplay: false,
            dots: false,
            loop: false,
            responsiveRefreshRate: 200,
            navText: [
            '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
            '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ]
        })
            .on("changed.owl.carousel", syncPosition);

        thumbs
            .on("initialized.owl.carousel", function() {
            thumbs
            .find(".owl-item")
            .eq(0)
            .addClass("current");
        })
            .owlCarousel({
            items: 5,
            margin:4,
            dots: false,
            nav: true,
            navText: [
            '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
            '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ],
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: 4,
            responsiveRefreshRate: 100
        })
            .on("changed.owl.carousel", syncPosition2);

        function syncPosition(el) {
            //if loop is set to false, then you have to uncomment the next line
            //var current = el.item.index;

            //to disable loop, comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

            if (current < 0) {
            current = count;
            }
            if (current > count) {
            current = 0;
            }
            //to this
            thumbs
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
            var onscreen = thumbs.find(".owl-item.active").length - 1;
            var start = thumbs
            .find(".owl-item.active")
            .first()
            .index();
            var end = thumbs
            .find(".owl-item.active")
            .last()
            .index();

            if (current > end) {
            thumbs.data("owl.carousel").to(current, 100, true);
            }
            if (current < start) {
            thumbs.data("owl.carousel").to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
            var number = el.item.index;
            bigimage.data("owl.carousel").to(number, 100, true);
            }
        }

        thumbs.on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).index();
            bigimage.data("owl.carousel").to(number, 300, true);
        });
    });
 

    // Hero banner
    // $('#herobanner').owlCarousel({
    //     loop:true,
    //     margin:10,
    //     nav:true,
    //     items:1,
    //     autoPlay:true,
    //     autoPlayTimeout:1000,
    //     autoPlayHoverPause:true
    // })

</script>

<!-- LinkedIn ad Campain -->
<script type="text/javascript">
    _linkedin_partner_id = "4766028";
    window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
    window._linkedin_data_partner_ids.push(_linkedin_partner_id);
    </script><script type="text/javascript">
    (function(l) {
    if (!l){window.lintrk = function(a,b){window.lintrk.q.push([a,b])};
    window.lintrk.q=[]}
    var s = document.getElementsByTagName("script")[0];
    var b = document.createElement("script");
    b.type = "text/javascript";b.async = true;
    b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
    s.parentNode.insertBefore(b, s);})(window.lintrk);
</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=4766028&fmt=gif" />
</noscript>