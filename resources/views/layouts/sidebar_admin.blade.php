<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        @if (Sentinel::hasAccess(['home']))
        <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link {{activeMenu(1, '')}}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Home</p>
            </a>
        </li>
        @endif

        @if (session()->get('_module')=='system')

        @if (Sentinel::hasAnyAccess(['auth.register_user','auth.users','system.user_permission','system.core.logs']))
        <li class="nav-item {{menuOpen(1, 'booking')}}">
            <a href="#" class="nav-link {{activeMenu(1, 'booking')}}">
                <i class="nav-icon fas fa-book-dead"></i>
                <p>
                    System
                    <i class="right fas fa-angle-down"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Sentinel::hasAccess(['auth.register_user']))
                <li class="nav-item">
                    <a href="{{route('auth.register_user')}}" class="nav-link">
                        <!-- <i class="nav-icon fas fa-user-alt"></i> -->
                        <i class="fas fa-circle"></i>
                        <p>Add User</p>
                    </a>
                </li>
                @endif

                @if (Sentinel::hasAccess(['auth.users']))
                <li class="nav-item">
                    <a href="{{route('auth.users')}}" class="nav-link">
                        <!-- <i class="nav-icon fas fa-user-alt"></i> -->
                        <i class="fas fa-circle"></i>
                        <p>User Manager</p>
                    </a>
                </li>
                @endif

                @if (Sentinel::hasAccess(['system.user_permission']))
                <li class="nav-item">
                    <a href="{{route('system.permission')}}" class="nav-link">
                        <!-- <i class="nav-icon fas fa-user-alt"></i> -->
                        <i class="fas fa-circle"></i>
                        <p>Permissions</p>
                    </a>
                </li>
                @endif
{{--                @if (Sentinel::hasAccess(['system.core.logs']))--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{url('system/core/logs')}}" class="nav-link">--}}
{{--                        <!-- <i class="nav-icon fas fa-user-alt"></i> -->--}}
{{--                        <i class="fas fa-circle"></i>--}}
{{--                        <p>Logs</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                @endif--}}

            </ul>
        </li>
        @endif
        @if (Sentinel::hasAccess(['base_setting']))
        <li class="nav-item">
            <a href="{{url('base_setting')}}" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>Settings</p>
            </a>
        </li>
        @endif
        @endif
        <li class="nav-item">
            <a href="{{route('sys.auth.logout')}}" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->