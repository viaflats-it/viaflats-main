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



</head>
<body>

<h3>Bienvenue</h3>

<a href="{!! URL::to('landlordCreateMail/'.$user->confirmation_code) !!}"><button>@lang('admin.confirm_account')</button> </a>
</body>
</html>
