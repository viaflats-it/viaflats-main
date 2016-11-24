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
{{ Html::style('css/boostrap.min.css') }}
<script>
    $( function() {
        $( ".datepicker" ).datepicker();
    } );
</script>