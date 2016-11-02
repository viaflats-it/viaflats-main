<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->

    <link href="{!! URL::asset('css/custom.css') !!}" rel="stylesheet">

    {{ Html::style('css/app.css') }}
    {{ Html::style('css/custom.css') }}
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
        @if(!Auth::user())
        <?php 
        $_SESSION['facebook_access_token'] = null;
        $_SESSION['google_access_token'] = null;
        ?>
        @endif
        @if(isset($_SESSION['facebook_access_token']))
        <?php 

        echo "<div style='float:right;'><a href='/logoutfb'><p style='float:top-right;display:inline;margin-right:10px'>".\Auth::user()->first_name." ".\Auth::user()->last_name." (".trans('auth.social_disconnect').")</p></a><img src='".\Auth::user()->profile_picture."'/></div>"; 

        ?>
        @elseif(isset($_SESSION['google_access_token']))
        <?php 

        echo "<div style='float:right;'><a href='/logoutgoogle'><p style='float:top-right;display:inline;margin-right:10px'>".\Auth::user()->first_name." ".\Auth::user()->last_name." (".trans('auth.social_disconnect').")</p></a><img src='".\Auth::user()->profile_picture." width='50' height='50' border='0'/></div>"; 

        ?>
        @endif
    </div>
</nav>

@if($errors->first() != "")
<div > {{$errors->first()}}</div>
@endif
@if(Auth::check())
@if(!$confirmed)
<div >
    <span>Please confirm email <a>Click here to send a confirmation send</a></span>
</div>
@endif
@endif
@yield('contenu')
</body>
</html>
