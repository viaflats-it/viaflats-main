<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->

    {{ Html::style('css/app.css') }}
    {{ Html::style('css/custom.css') }}
    {{ Html::style('css/boostrap.min.css') }}
    {{ Html::style('../node_modules/material-design-icons-iconfont/dist/material-design-icons.css') }}
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- jQuery -->
    <script src="{{URL::asset('js/app.js')}}"></script>



</head>
<body>
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="landlord">
                    @lang('landlord.landlord')
                </a>
            </li>
            <li>
                <a href="profile">@lang('photographer.profile')</a>
            </li>
            <li>
                <a href="my_appointment">@lang('photographer.my_appointment')</a>
            </li>
            <li>
                <a href="my_availabilities">@lang('photographer.my_availabilities')</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index">Viaflats</a>
                        </div>
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Home</a></li>
                            @if(Auth::check())
                                <li><a>{{Auth::user()->login}}</a>

                                </li>
                                <li><a href="logout">
                                        <button class="btn btn-danger">Logout</button>
                                    </a>
                                </li>
                            @else
                                <li><a id="login">Login</a></li>
                                <li><a id="signup">Signup</a></li>
                            @endif
                        </ul>
                    </div>
                </nav>

                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">@lang('landlord.menu-toggle')</a>

                <div class="content">
                    @yield('content')

                </div>

            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->



<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
</body>
</html>