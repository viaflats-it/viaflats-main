<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Verify Your Email Address Landlord </h2>

<div>
    Hi {{$user->first_name}} !
    Thanks for creating an account with the verification demo app.
    Please follow the link below to verify your email address
    {{ URL::to('confirmation/mail/'.$user->confirmation_code)}} <br/>

</div>

</body>
</html>