@if (session()->has('success'))

    <div class="alert alert-info alert-dismissible show fade">
        <strong>{{ Session::get('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

@endif


@if (session()->has('errors'))

    <div class="alert alert-danger alert-dismissible show fade">
        <strong>{{ Session::get('errors') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

@endif

{{--@if ($errors->any())--}}

{{--    <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">--}}
{{--        <div class="alert alert-danger alert-dismissible show fade">--}}
{{--            <strong>  {!! implode('', $errors->all('<div>:message</div>')) !!}</strong>--}}
{{--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--@endif--}}
