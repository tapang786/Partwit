<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title)?$title.' - ' : '' }}{{ trans('panel.site_title') }}</title>
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

    @include('partials.admin.navbar')

    <div class="page-container">

        @include('partials.sidebar')

        <!-- Page content -->
        <div class="page-content">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-title">
                    <h3>Dashboard <small>Welcome Admin!</small></h3>
                </div>

                {{-- <div id="reportrange" class="range">
                    <div class="visible-xs header-element-toggle">
                        <a class="btn btn-primary btn-icon"><i class="icon-calendar"></i></a>
                    </div>
                    <div class="date-range"></div>
                    <span class="label label-danger">9</span>
                </div> --}}
            </div>
            <!-- /page header -->


            <!-- Breadcrumbs line -->
            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li><a href="{{url('admin')}}">Home</a></li>
                    <li class="active">{{ isset($title)?$title: '' }}</li>
                </ul>

                <div class="visible-xs breadcrumb-toggle">
                    <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
                </div>

                {{-- <ul class="breadcrumb-buttons collapse">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-search3"></i> <span>Search</span> <b class="caret"></b></a>
                        <div class="popup dropdown-menu dropdown-menu-right">
                            <div class="popup-header">
                                <a href="#" class="pull-left"><i class="icon-paragraph-justify"></i></a>
                                <span>Quick search</span>
                                <a href="#" class="pull-right"><i class="icon-new-tab"></i></a>
                            </div>
                            <form action="#" class="breadcrumb-search">
                                <input type="text" placeholder="Type and hit enter..." name="search" class="form-control autocomplete">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled" checked="checked">
                                            Everywhere
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled">
                                            Invoices
                                        </label>
                                    </div>

                                    <div class="col-xs-6">
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled">
                                            Users
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled">
                                            Orders
                                        </label>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-block btn-success" value="Search">
                            </form>
                        </div>
                    </li>

                    <li class="language dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/flags/german.png" alt=""> <span>German</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu dropdown-menu-right icons-right">
                            <li><a href="#"><img src="images/flags/ukrainian.png" alt=""> Ukrainian</a></li>
                            <li class="active"><a href="#"><img src="images/flags/english.png" alt=""> English</a></li>
                            <li><a href="#"><img src="images/flags/spanish.png" alt=""> Spanish</a></li>
                            <li><a href="#"><img src="images/flags/german.png" alt=""> German</a></li>
                            <li><a href="#"><img src="images/flags/hungarian.png" alt=""> Hungarian</a></li>
                        </ul>
                    </li>
                </ul> --}}
            </div>
            <!-- /breadcrumbs line -->

            @yield('content')

            @include('partials.admin.footer')            

        </div>
        <!-- /page content -->
        
    </div>
    
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

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
</body>

</html>
