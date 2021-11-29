
<div class="sidebar">
    <div class="sidebar-content">

        <!-- User dropdown -->
        <!-- <div class="user-menu dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="http://placehold.it/200">
                <div class="user-info">
                    Admin {{-- <span>Web Developer</span> --}}
                </div>
            </a>
            <div class="popup dropdown-menu dropdown-menu-right">
                <div class="thumbnail">
                    <div class="thumb">
                        <img src="http://placehold.it/300">
                        <div class="thumb-options">
                            <span>
                                <a href="#" class="btn btn-icon btn-success"><i class="icon-pencil"></i></a>
                                <a href="#" class="btn btn-icon btn-success"><i class="icon-remove"></i></a>
                            </span>
                        </div>
                    </div>
                
                    <div class="caption text-center">
                        <h6>Admin <small></small></h6>
                    </div>
                </div>

                <ul class="list-group">
                    <li class="list-group-item"><i class="icon-pencil3 text-muted"></i> My posts <span class="label label-success">289</span></li>
                    <li class="list-group-item"><i class="icon-people text-muted"></i> Users online <span class="label label-danger">892</span></li>
                    <li class="list-group-item"><i class="icon-stats2 text-muted"></i> Reports <span class="label label-primary">92</span></li>
                    <li class="list-group-item"><i class="icon-stack text-muted"></i> Balance <h5 class="pull-right text-danger">$45.389</h5></li>
                </ul>
            </div>
        </div> -->
        <!-- /user dropdown -->


        <!-- Main navigation -->
        <ul class="navigation">
            <li class="{{ request()->is('admin') ? 'active' : '' }}">
                <a href="{{ route("admin.home") }}">
                    <span>{{ trans('global.dashboard') }}</span> <i class="icon-screen2"></i>
                </a>
            </li>

            @can('user_access')
            <li class="{{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                <a href="{{ route("admin.users.index") }}">
                    <span>{{ trans('cruds.user.title') }}</span> <i class="icon-user"></i>
                </a>
            </li>
            @endcan

            <li class="{{ request()->is('admin/drivers') || request()->is('admin/drivers/*') ? 'active' : '' }}">
                <a href="{{ route("admin.drivers.index") }}">
                    <span>{{ trans('cruds.driver.title') }}</span> <i class="fa fa-bus"></i>
                </a>
            </li>

            <li class="{{ request()->is('admin/city') || request()->is('admin/city/*') ? 'active' : '' }}">
                <a href="{{ route("admin.city.index") }}">
                    <span>{{ trans('cruds.city.title') }}</span> <i class="fa fa-city"></i>
                </a>
            </li>

            <li class="{{ request()->is('admin/advertisement') || request()->is('admin/advertisement/*') ? 'active' : '' }}">
                <a href="{{ route("admin.advertisement.index") }}">
                    <span>{{ trans('cruds.advertisement.title') }}</span> <i class="fa fa-puzzle-piece"></i>
                </a>
            </li>

            <li class="{{ request()->is('admin/pages') || request()->is('admin/pages/*') ? 'active' : '' }}">
                <a href="{{ route("admin.pages.index") }}">
                    <span>{{ __('Pages') }}</span> <i class="fa fa-puzzle-piece"></i>
                </a>
            </li>

            <li class="{{ request()->is('admin/subscription') || request()->is('admin/subscription/*') ? 'active' : '' }}">
                <a href="{{ route("admin.subscription.index") }}">
                    <span>{{ trans('cruds.subscription.title') }}</span> <i class="fa fa-paper-plane"></i>
                </a>
            </li>

            <li class="{{ request()->is('admin/payments') || request()->is('admin/payments/*') ? 'active' : '' }}">
                <a href="{{ route("admin.payments.index") }}">
                    <span>{{ __('Payments') }}</span> <i class="fa fa-credit-card"></i>
                </a>
            </li>

            {{-- @can('user_management_access')
            <li>
                <a href="#"><span>{{ trans('cruds.userManagement.title') }}</span> <i class="icon-user-plus"></i></a>
                <ul>
                @can('permission_access')
                    <li class="{{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}"><a href="{{ route("admin.permissions.index") }}">{{ trans('cruds.permission.title') }}</a></li>
                @endcan

                @can('role_access')
                    <li class="{{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}"><a href="{{ route("admin.roles.index") }}">{{ trans('cruds.role.title') }}</a></li>
                @endcan

                </ul>
            </li>
            @endcan --}}
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <span>{{ trans('global.logout') }}</span><i class="fas fa-fw fa-sign-out-alt"></i>   
                </a>
            </li>
        </ul>
        <!-- /main navigation -->
        
    </div>
</div>