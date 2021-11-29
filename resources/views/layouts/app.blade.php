<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet" />
    {{-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet" /> --}}

    <link href="{{ asset('css') }}/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css') }}/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css') }}/styles.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css') }}/icons.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

    @yield('styles')

</head>

<body>
    @yield('content')

    {{-- Scripts  --}}
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/charts') }}/sparkline.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/uniform.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/inputmask.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/autosize.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/inputlimit.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/listbox.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/multiselect.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/tags.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms') }}/switch.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/forms/uploader') }}/plupload.full.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/uploader') }}/plupload.queue.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/forms/wysihtml5') }}/wysihtml5.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/wysihtml5') }}/toolbar.js"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/daterangepicker.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/fancybox.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/moment.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/jgrowl.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/colorpicker.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/fullcalendar.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/interface') }}/timepicker.min.js"></script>

    <script type="text/javascript" src="{{ asset('js') }}/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('js') }}/application.js"></script>

    @yield('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="{{ asset('js/bootstrap-material-design.min.js') }}"></script>
    <script src="{{ asset('js/material-dashboard.js') }}"></script> --}}

</body>

</html>
