@extends('layouts.app')
@section('content')
<div class="full-width page-condensed">
    <!-- Navbar -->
    <div class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-right">
                <span class="sr-only">Toggle navbar</span>
                <i class="icon-grid3"></i>
            </button>
            <a class="navbar-brand" href="#"><img src="images/logo.png" alt="Londinium"></a>
        </div>

        {{-- <ul class="nav navbar-nav navbar-right collapse">
            <li><a href="#"><i class="icon-screen2"></i></a></li>
            <li><a href="#"><i class="icon-paragraph-justify2"></i></a></li>
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
                <ul class="dropdown-menu icons-right dropdown-menu-right">
                    <li><a href="#"><i class="icon-cogs"></i> This is</a></li>
                    <li><a href="#"><i class="icon-grid3"></i> Dropdown</a></li>
                    <li><a href="#"><i class="icon-spinner7"></i> With right</a></li>
                    <li><a href="#"><i class="icon-link"></i> Aligned icons</a></li>
                </ul>
            </li>
        </ul> --}}
    </div>
    <!-- /navbar -->


    <!-- Login wrapper -->
    <div class="login-wrapper">
        <form action="{{ route('login') }}" role="form" method="POST">
            {{ csrf_field() }}
            <div class="popup-header">
                {{-- <a href="#" class="pull-left"><i class="icon-user-plus"></i></a> --}}
                <span class="text-semibold">User Login</span>
                {{-- <div class="btn-group pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
                    <ul class="dropdown-menu icons-right dropdown-menu-right">
                        <li><a href="#"><i class="icon-people"></i> Change user</a></li>
                        <li><a href="#"><i class="icon-info"></i> Forgot password?</a></li>
                        <li><a href="#"><i class="icon-support"></i> Contact admin</a></li>
                        <li><a href="#"><i class="icon-wrench"></i> Settings</a></li>
                    </ul>
                </div> --}}
            </div>
            <div class="well">
                <div class="form-group has-feedback">
                    <label>Username</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('global.login_email') }}" name="email" value="{{ old('email', null) }}">
                    <i class="icon-users form-control-feedback"></i>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <label>Password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}" name="password">
                    <i class="icon-lock form-control-feedback"></i>
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="row form-actions">
                    <div class="col-xs-6">
                        <div class="checkbox checkbox-success">
                        <label>
                            <input type="checkbox" name="remember" id="remember" class="styled">
                            {{ trans('global.remember_me') }}
                        </label>
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-warning pull-right"><i class="icon-menu2"></i>{{ trans('global.login') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>  
    <!-- /login wrapper -->

    @include('partials.admin.footer')

</div>

@endsection
