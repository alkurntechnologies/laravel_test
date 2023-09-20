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




@if ($message = Session::get('success'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-success custom-alert-success   alert-block text-center">
                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>
                    <div>{{ $message }}</div>

                </div>
            </div>
        </div>


@endif

{{--Alert code for status--}}
@if ($message = Session::get('status'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-success custom-alert-success   alert-block text-center">
                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>
                    <div>{{ $message }}</div>
                </div>
            </div>
        </div>


@endif

{{--Alert code for error--}}
@if ($message = Session::get('error'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger  custom-alert-danger   alert-block  text-center">
                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>
                    <div>{{ $message }}</div>
                </div>
            </div>
        </div>

@endif

{{--Alert code for danger--}}
@if ($message = Session::get('danger'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger  custom-alert-danger   alert-block  text-center">
                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>

                    <div>{{ $message }}</div>

                </div>
            </div>
        </div>


@endif

{{--Alert code for warning--}}
@if ($message = Session::get('warning'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning alert-block custom-alert-warning    text-center">
                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>

                    <div>{{ $message }}</div>

                </div>
            </div>
        </div>

@endif

{{--Alert code for info--}}
@if ($message = Session::get('info'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-info custom-alert-info  alert-block  text-center">

                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>
                    <div>{{ $message }}</div>

                </div>
            </div>
        </div>

@endif

{{--Alert code for primary--}}
@if ($message = Session::get('primary'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-info custom-alert-primary  alert-block  text-center">
                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>

                    <div>{{ $message }}</div>

                </div>
            </div>
        </div>

@endif

{{--Alert code for Secondary--}}
@if ($message = Session::get('secondary'))


        <div class="row">
            <div class="col-12">
                <div class="alert alert-info custom-alert-secondary  alert-block  text-center">

                    <button type="button" class="close custom-alert-close" data-dismiss="alert">×</button>
                    <div>{{ $message }}</div>

                </div>
            </div>
        </div>

@endif

{{--Alert code for any--}}

@if ($errors->any())


    <div class="alert alert-danger custom-alert-danger   text-center">

        {{$errors->first()}}

    </div>

@endif


<script>
    $(".alert").each(function () {
        setTimeout(function () {
            $(".alert").slideUp(15000);
            //$(".alert").addClass('fadeOutUp');
        }, 10000);
    });
</script>


