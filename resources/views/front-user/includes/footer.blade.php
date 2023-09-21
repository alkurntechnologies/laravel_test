<!-- ======= Footer ======= -->
<footer id="footer" class="footer">

    <div class="footer-newsletter">
        <div class="container">
            <div class="d-flex">
                <h4>Follow us</h4>
                <div class="socialLinksAut">
                    <ul>
                        <li>
                            <a href="#" target="_blank">
                                <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/facebook_social.png" class="img-fluid" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/linkedin_social.png" class="img-fluid" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/instagram_social.png" class="img-fluid" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-12 footer-info">
                    <a href="{{url('')}}" class="logo d-flex align-items-center">
                        <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/new-logo-black.png" alt="">
                    </a>
                </div>

                <div class="col-lg-8 col-12 footer-links">
                    <h4>Links</h4>
                    
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <ul>
                                <li class="{{url('')==url()->current()?'active':''}}"><a href="{{url('')}}">Home</a></li>
                                <li class="{{url('product-list')==url()->current()?'active':''}}"><a href="{{url('product-list')}}">Shop</a></li>
                            </ul>
                        </div>
                        @if(!Auth::check())
                        <div class="col-md-3 col-6">
                            <ul>
                                <li class="{{url('login')==url()->current()?'active':''}}"><a href="{{url('login')}}">Sign in</a></li>
                                <li class="{{url('signup')==url()->current()?'active':''}}"><a href="{{url('signup')}}">Sign up</a></li>
                                <!-- <li class="{{url('signup/seller')==url()->current()?'active':''}}"><a href="{{url('signup/seller')}}">Become a seller</a></li>
                                <li class="{{url('signup/shipper')==url()->current()?'active':''}}"><a href="{{url('signup/shipper')}}">Become a shipper</a></li> -->
                            </ul>
                        </div>
                        @endif
                        <div class="col-md-3 col-6">
                            <ul>
                              
                                <li class="{{url('terms-and-conditions')==url()->current()?'active':''}}"><a href="{{url('terms-and-conditions')}}">Terms and conditions</a></li>
                                <li class="{{url('cookies-policy')==url()->current()?'active':''}}"><a href="{{url('cookies-policy')}}">Cookies policy</a></li>
                                <li class="{{url('return-policy')==url()->current()?'active':''}}"><a href="{{url('return-policy')}}">Return policy</a></li>

                            </ul>
                        </div>
                        <div class="col-md-3 col-6">
                            <img loading="lazy" class="sticker-image" width="200" src="{{ asset('/') }}assets/front-end/images/NaVOBA_Certification_Veterans_Seals.png" alt="">
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            E-Railspot Marketplace © {{date('Y')}} All Rights Reserved. Designed and developed by <a href="https://alkurn.co.in/">Alkurn Technologies</a>.
        </div>
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    @include("front-user.includes.footer-bottom")
</footer><!-- End Footer -->