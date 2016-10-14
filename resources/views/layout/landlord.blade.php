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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="datepair.js"></script>
    <script type="text/javascript" src="jquery.datepair.js"></script>


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
                <a href="profile">@lang('landlord.profile')</a>
            </li>
            <li>
                <a href="add_property">@lang('landlord.add_property')</a>
            </li>
            <li>
                <a href="my_properties">@lang('landlord.my_properties')</a>
            </li>
            <li>
                <a href="my_booking">@lang('landlord.my_booking')</a>
            </li>
            <li>
                <a href="update_availabilities">@lang('landlord.update_availabilities')</a>
            </li>
            <li>
                <a href="invoices">@lang('landlord.invoices')</a>
            </li>
            <li>
                <a href="messages">@lang('landlord.messages')</a>
            </li>
            @if(Auth::user()->admin == 1)
                <li>
                    <span class="adminAddlandlord"><a href="#">@lang('landlord.adminAddlandlord')</a></span>
                </li>
                @endif
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
                    @yield('contenu')

                </div>

            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->


<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
</body>
</html>
