<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>

    <!-- Fonts -->

    {{ Html::style('css/app.css') }}
    {{ Html::style('css/custom.css') }}
    <script src="{{URL::asset('js/app.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>

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
        @if(isset($_SESSION['facebook_access_token']))
            <?php

            $fb = new Facebook\Facebook(['app_id' => '220761998341263',
                    'app_secret' => 'ed4cb1999a7d9ff37b4054c7befb282f',
                    'default_graph_version' => 'v2.5',]);

            $response = $fb->get('/me?fields=id,first_name, last_name,link,email,age_range', $_SESSION['facebook_access_token']);
            $userNode = $response->getGraphUser();


            echo "<div style='float:right;'><a href='/logoutfb'><p style='float:top-right;display:inline;margin-right:10px'>" . $userNode['first_name'] . " " . $userNode['last_name'] . " (" . trans('auth.fb_disconnect') . ")</p></a><img style='' src='http://graph.facebook.com/" . $userNode['id'] . "/picture'/></div>";

            ?>
        @endif
    </div>
</nav>


@if(Auth::check())
    @if(!$confirmed)
        <div>
            <span>Please confirm email <a>Click here to send a confirmation send</a></span>
        </div>
    @endif
@endif
@yield('contenu')
</body>
</html>
