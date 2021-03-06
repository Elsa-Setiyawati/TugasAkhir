<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    @include('layouts.partials.css')
</head>
<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
             <a class="navbar-brand" style="color:#fff">
                        <b> SIA - PERSEDIAAN </b>  </a> 
                    
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                    <!-- <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li> -->
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- <li class="nav-item">
                        
                        <b> SIA - PERSEDIAAN </b>
                        </li> -->
                    </ul>
                    
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('assets/images/users/user.jpg') }}" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{ asset('assets/images/users/user.jpg') }}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{Auth::user()->name}}</h4>
                                                <p class="text-muted">{{Auth::user()->email}}</p><a class="btn btn-rounded btn-danger btn-sm">{{Auth::user()->hak_akses}}</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="/users/edit/{{ Auth::user()->id }}"><i class="ti-settings"></i> Setting</a></li>
                                    <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fa fa-power-off"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                        @csrf
                                    </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <div class="user-profile" style="background: url({{ asset('assets/images/background/profile-bg.jpg') }}) no-repeat;">
                    <div class="profile-img"> <img src="{{ asset('assets/images/users/profile.png') }}" alt="user" /> </div>
                    <div class="profile-text"> <a  aria-haspopup="true" aria-expanded="true">{{Auth::user()->name}}</a>
                </div>
                </div>
                @include('layouts.partials.menu')
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <br/>
                @yield('konten')
            </div>
            <footer class="footer">  
            <?php echo " " . (int)date('Y') . "" . "-"."Created by Els"; ?>
        </footer>
        </div>
    </div>
    @include('layouts.partials.js')
</body>

</html>