@extends('layout.tenant')

@section('contenu')
    <!---- Different button for every case -------->
    <div>
        <a>@lang('tenant.pending')</a>
        <a>@lang('tenant.waiting')</a>
        <a>@lang('tenant.confirmed')</a>
        <a>@lang('tenant.rejected')</a>
    </div>

    <!----- All Reservation ----------->
    <div>
        <button id="Test">Test</button>
    </div>

    <script>
        $('#Test').on('click', function (event) {
            event.preventDefault();
            var posting = $.ajax({
                url: 'showAllReservation',
            })
            posting.done(function (data){
                console.log(data);
            });
        });

    </script>
@endsection