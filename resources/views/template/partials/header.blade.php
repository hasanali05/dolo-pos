<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header border-right">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <a class="navbar-brand" href="index.html">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{asset('/')}}/template/assets/images/logos/logo-icon.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="{{asset('/')}}/template/assets/images/logos/logo-light-icon.png" alt="homepage" class="light-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                     <!-- dark Logo text -->
                     <img src="{{asset('/')}}/template/assets/images/logos/logo-text.png" alt="homepage" class="dark-logo" />
                     <!-- Light Logo text -->    
                     <img src="{{asset('/')}}/template/assets/images/logos/logo-light-text.png" class="light-logo" alt="homepage" />
                </span>
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-18"></i></a></li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                @php($user = Auth::guard('admin')->check()?Auth::guard('admin')->user() :  (Auth::guard('employee')->check()?Auth::guard('admin')->user() : '' ))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset('/')}}/template/assets/images/users/1.jpg" alt="user" class="rounded-circle" width="36">
                        <span class="ml-2 font-medium">{{ $user?explode(" ",trim($user->name))[0]:'Steave' }}</span><span class="fas fa-angle-down ml-2"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <div class="d-flex no-block align-items-center p-3 mb-2 border-bottom">
                            <div class=""><img src="{{asset('/')}}/template/assets/images/users/1.jpg" alt="user" class="rounded" width="80"></div>
                            <div class="ml-2">
                                <h4 class="mb-0">{{ $user?trim($user->name):'Steave Jobs' }}</h4>
                                <p class=" mb-0 text-muted">{{ Auth::user()?Auth::user()->email:'Steave Jobs' }}</p>
                                <a href="{{ Auth::guard('admin')->check()?route('admin.myprofile') :  (Auth::guard('employee')->check()?route('employee.myprofile') : '' )}}" class="btn btn-sm btn-danger text-white mt-2 btn-rounded">View Profile</a>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ Auth::guard('admin')->check()?route('admin.myprofile') :  (Auth::guard('employee')->check()?route('employee.myprofile') : '' )}}"><i class="ti-user mr-1 ml-1"></i> My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ Auth::guard('admin')->check()?route('admin.changePassword') :  (Auth::guard('employee')->check()?route('employee.changePassword') : '' )}}"><i class="ti-settings mr-1 ml-1"></i> Change password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                     <i class="fa fa-power-off mr-1 ml-1"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ Auth::guard('admin')->check()?route('admin.logout') :  (Auth::guard('employee')->check()?route('employee.logout') : '' )}}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>