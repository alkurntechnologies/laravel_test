{{--Test all Flash messages--}}

{{--<div class="alert alert-success custom-alert-success animated  flash  alert-block text-center">--}}
{{--<button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>--}}
{{--<span>This is some testing message</span>--}}
{{--</div>--}}

{{--<div class="alert alert-danger  custom-alert-danger  animated  flash alert-block  text-center">--}}
{{--<button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>--}}
{{--<span>This is some testing message</span>--}}
{{--</div>--}}

{{--<div class="alert alert-warning alert-block custom-alert-warning  animated  flash  text-center">--}}
{{--<button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>--}}
{{--<span>This is some testing message</span>--}}
{{--</div>--}}

{{--<div class="alert alert-info alert-block custom-alert-info animated  flash  text-center">--}}
{{--<button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>--}}
{{--<span>This is some testing message</span>--}}
{{--</div>--}}

{{--<div class="alert alert-primary custom-alert-primary animated  flash alert-block  text-center">--}}
{{--<button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>--}}
{{--<span>This is some testing message</span>--}}
{{--</div>--}}

{{--<div class="alert alert-secondary custom-alert-secondary animated  flash alert-block  text-center">--}}
{{--<button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>--}}
{{--<span>This is some testing message</span>--}}
{{--</div>--}}

{{--Alert code for Success--}}

<div id="overlay">
    <div class="loaderContent">This can take up to 90 seconds</div>
    <img loading="lazy" src="{{asset('/assets/front-end/images/loader1.gif') }}" id="loading-image" alt="">
</div>

{{--Overlay Css--}}
<style>
    #overlay {
        display: none;
        position: fixed; /* Sit on top of the page content */

        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(251, 251, 251, 0.86); /* Black background with opacity */
        z-index: 99999; /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer; /* Add a pointer on hover */

    }

    .modal-open #overlay { background: transparent; }


    #loading-image {
        position: absolute;
        z-index: 999;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        margin: auto;

    }

    /*.alert {
        position: fixed;
        width: 100%;
        z-index: 999;
        margin-top: 100px;
    }*/
</style>


@if ($message = Session::get('success'))
    <script type="text/javascript">toastr.success('{!! $message !!}');</script>
@endif

@if ($message = Session::get('error'))
    <script type="text/javascript">toastr.error('{!! $message !!}');</script>
@endif

@if ($message = Session::get('warning'))
    <script type="text/javascript">toastr.warning('{!! $message !!}');</script>
@endif

@if ($message = Session::get('info'))
    <script type="text/javascript">toastr.info('{!! $message !!}');</script>
@endif

@if (isset($errors) && $errors->any())
    <script type="text/javascript">toastr.error('{{$errors->first()}}');</script>
@endif
