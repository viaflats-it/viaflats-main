

<html>
<form method="post", action="search">
  <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
  test
  <input name="city" type="text">
  <input class="datepicker" name="start" type="text">
  <input class="datepicker" name="end" type="text">
  <button type="submit">click</button>
</form>
</html>


<script src="{{URL::asset('js/app.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

  $( function() {
    $( ".datepicker" ).datepicker();
  } );

</script>