<!-- Sidebar -->
<div class="sidebar" data-color="orange" data-background-color="white">
    <!-- Brand Logo -->
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-wrapper">
        <ul class="nav" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <p>
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>{{ trans('global.dashboard') }}</span>
                    </p>
                </a>
            </li>

            @can('product_management_access')
            <li class="nav-item has-treeview {{ request()->is('dashboard/permissions*') ? 'menu-open' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#product_management">
                    <i class="fab fa-product-hunt"></i>
                    <p>
                        <span>Products</span>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ request()->is('dashboard/category') || request()->is('dashboard/category/*') ? 'show' : '' }}" id="product_management">
                    <ul class="nav">

                        @can('category_management_access')
                        <li class="nav-item {{ request()->is('dashboard/category') || request()->is('dashboard/category/*') ? 'active' : '' }}">
                            <a href="{{ route("admin.category.index") }}" class="nav-link " class="nav-link" >
                                <i class="fas fa-list-alt"></i> 
                                <span>Category</span>
                            </a>
                        </li>
                        @endcan
                        
                    </ul>
                </div>
            </li>
            @endcan
            

            @can('user_management_access')
            <li class="nav-item {{ request()->is('dashboard/subscription') || request()->is('dashboard/subscription/*') ? 'active' : '' }}">
                <a href="{{ route("admin.subscription.index") }}" class="nav-link" class="nav-link" >
                    <p>
                        <i class="fa fa-paper-plane"></i>
                        <span>{{ trans('cruds.subscription.title') }}</span>
                    </p>
                </a>
            </li>
            @endcan
            @can('user_management_access')
                <li class="nav-item has-treeview {{ request()->is('dashboard/permissions*') ? 'menu-open' : '' }} {{ request()->is('dashboard/roles*') ? 'menu-open' : '' }} {{ request()->is('dashboard/users*') ? 'menu-open' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#user_management">
                        <i class="fa-fw fas fa-users"></i>
                        <p>
                            <span>{{ trans('cruds.userManagement.title') }}</span>
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ request()->is('dashboard/users') || request()->is('dashboard/users/*') || request()->is('dashboard/roles') || request()->is('dashboard/roles/*') || request()->is('dashboard/permissions') || request()->is('dashboard/permissions/*') ? 'show' : '' }}" id="user_management">
                        <ul class="nav">
                            
                            @can('user_access')
                                <li class="nav-item {{ request()->is('dashboard/users') || request()->is('dashboard/users/*') ? 'active' : '' }}">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link">
                                        <i class="fa-fw fas fa-user"></i>
                                        <span>{{ trans('cruds.user.title') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('permission_access')
                                <li class="nav-item {{ request()->is('dashboard/permissions') || request()->is('dashboard/permissions/*') ? 'active' : '' }}">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link">
                                        <i class="fa-fw fas fa-unlock-alt"></i>
                                        <span>{{ trans('cruds.permission.title') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('role_access')
                                <li class="nav-item {{ request()->is('dashboard/roles') || request()->is('dashboard/roles/*') ? 'active' : '' }}">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link">
                                        <i class="fa-fw fas fa-briefcase"></i>
                                        <span>{{ trans('cruds.role.title') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('role_access')
                                <li class="nav-item {{ request()->is('dashboard/vendor') || request()->is('dashboard/vendor/*') ? 'active' : '' }}">
                                    <a href="{{ route("admin.vendor") }}" class="nav-link">
                                        <i class="fa-fw fas fa-briefcase"></i>
                                        <span>Sellers</span>
                                    </a>
                                </li>
                            @endcan
                            
                        </ul>
                    </div>
                </li>
            @endcan
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <p>
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>{{ trans('global.logout') }}</span>
                    </p>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
