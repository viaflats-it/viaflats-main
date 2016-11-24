@extends('layout.tenant')

@section('contenu')
    <!---- Different button for every case -------->
    <div style="text-align: center">
        <a id="pending">@lang('tenant.pending')</a>
        <a id="waiting">@lang('tenant.waiting')</a>
        <a id="confirmed">@lang('tenant.confirmed')</a>
        <a id="rejected">@lang('tenant.rejected')</a>
        <a id="expired">@lang('tenant.expired')</a>
    </div>

    <!------- All Reservation -------->
    <div class="row" id="reservation">
        <div style="display:none">{{$i=0}}</div>
        @foreach($booking as $a)
            <div class="col-md-4" id="#{{$a->idBooking}}">
                <div>{{$estate[$i]['attributes']['title']}}</div>
                <img src="property/{{$estate[$i]['attributes']['picture']}} " width="100" height="...">
                <div> @lang('tenant.booking_request') {{$a->idBooking}} </div>
                <div>{{$a->checkin}} @lang('tenant.to') {{$a->checkout}} </div>
                <div> @lang('tenant.guest') {{$a->guest}}</div>
                @if($a->status == 'waiting')
                    <div> @lang('tenant.to_paid') {{$a->booking_fee}} €</div>
                @elseif($a->status == 'rejected')
                    <div> @lang("tenant.reject_cause")</div>
                @endif
            </div>
            <div style="display:none">{{$i++}}</div>
        @endforeach
    </div>

    <script>
        $('#pending').on('click', function (event) {
            event.preventDefault();
            var posting = $.ajax({
                url: 'showPending',
            })
            posting.done(function (data) {
                $("#reservation").html("");
                $(data.booking).each(function (index, value) {
                    $("#reservation").append(
                            '<div class="col-md-4" id="#' + value.idBooking + '" style="width: 300px;">' +
                            '<div>' + data.estate[index].title + '</div>' +
                            '<img src="property/' + data.estate[index].picture +
                            '"width="100" height="...">' +
                            '<div> @lang('tenant.booking_request')' + value.idBooking + '</div>' +
                            '<div>' + value.checkin + ' @lang('tenant.to')' + value.checkout + '</div>' +
                            '<div> @lang('tenant.guest')' + data.estate[index].guest_nb + '</div>' +
                            '</div> <br>'
                    );
                });
            });
        });

        $('#waiting').on('click', function (event) {
            event.preventDefault();
            var posting = $.ajax({
                url: 'showWaiting',
            })
            posting.done(function (data) {
                $("#reservation").html("");
                $(data.booking).each(function (index, value) {
                    $("#reservation").append(
                            '<div id="#' + value.idBooking + '" style="width: 300px;">' +
                            '<div>' + data.estate[index].title + '</div>' +
                            '<img src="property/' + data.estate[index].picture +
                            '"width="100" height="...">' +
                            '<div> @lang('tenant.booking_request') ' + value.idBooking + '</div>' +
                            '<div> ' + value.checkin + ' @lang('tenant.to')' + value.checkout + '</div>' +
                            '<div> @lang('tenant.guest')' + data.estate[index].guest_nb + '</div>' +
                            '<div> @lang('tenant.to_paid')' + value.booking_fee + '</div>' +
                            '</div> <br>'
                    );
                });
            });
        });

        //Rajouter messagerie
        $('#confirmed').on('click', function (event) {
            event.preventDefault();
            var posting = $.ajax({
                url: 'showConfirmed',
            })
            posting.done(function (data) {
                console.log(data);
                $("#reservation").html("");
                $(data.booking).each(function (index, value) {
                    $("#reservation").append(
                            '<div id="#' + value.idBooking + '" style="width: 300px;">' +
                            '<div>' + data.estate[index].title + '</div>' +
                            '<img src="property/' + data.estate[index].picture +
                            '"width="100" height="...">' +
                            '<div> @lang('tenant.booking_request')' + value.idBooking + '</div>' +
                            '<div>' + value.checkin + ' @lang('tenant.to')' + value.checkout + '</div>' +
                            '<div> @lang('tenant.guest')' + data.estate[index].guest_nb + '</div>' +
                            '</div> <br>'
                    );
                });
            });
        });

        $('#rejected').on('click', function (event) {
            event.preventDefault();
            var posting = $.ajax({
                url: 'showRejected',
            })
            posting.done(function (data) {
                $("#reservation").html("");
                $(data.booking).each(function (index, value) {
                    if (value.rejection_cause == 'other') {
                        $("#reservation").append(
                                '<div id="#' + value.idBooking + '"style="width:300px;border:dashed">' +
                                '<div>' + data.estate[index].title + '</div>' +
                                '<img src="property/' + data.estate[index].picture +
                                '"width="100" height="...">' +
                                '<div> @lang('tenant.booking_request')' + value.idBooking + '</div>' +
                                '<div> Period ' + value.checkin + '@lang('tenant.to')' + value.checkout + '</div>' +
                                '<div> @lang('tenant.guest') ' + data.estate[index].guest_nb + '</div>' +
                                '<div> @lang("tenant.reject_cause")</div>' +
                                '</div> <br>');
                    } else {
                        $("#reservation").append(
                                '<div id="#' + value.idBooking + '"style="width:300px;border:dashed;" >' +
                                '<div>' + data.estate[index].title + '</div>' +
                                '<img src="property/' + data.estate[index].picture +
                                '"width="100" height="...">' +
                                '<div> @lang('tenant.booking_request')' + value.idBooking + '</div>' +
                                '<div> ' + value.checkin + ' @lang('tenant.to') ' + value.checkout + '</div>' +
                                '<div> @lang('tenant.guest')' + data.estate[index].guest_nb + '</div>' +
                                '<div>' + value.rejection_cause + '</div>' +
                                '</div> <br>'
                        );
                    }

                });
            });
        });

        $('#expired').on('click', function (event) {
            event.preventDefault();
            var posting = $.ajax({
                url: 'showExpired',
            });
            posting.done(function (data) {
                $("#reservation").html("");
                $(data.booking).each(function (index, value) {
                    $("#reservation").append(
                            '<div id="#' + value.idBooking + '" style="width: 300px;">' +
                            '<div>' + data.estate[index].title + '</div>' +
                            '<img src="property/' + data.estate[index].picture +
                            '"width="100" height="...">' +
                            '<div> @lang('tenant.booking_request') ' + value.idBooking + '</div>' +
                            '<div>' + value.checkin + '@lang('tenant.to')' + value.checkout + '</div>' +
                            '<div> @lang('tenant.guest')' + data.estate[index].guest_nb + '</div>' +
                            '</div> <br>'
                    );
                });
            });
        });

        $("#reservation").on('click', "[id^='#']", function () {
            var id = $(this).attr('id').replace('#', '');
            window.open("reservation-details?ref=" + id);
        });

    </script>
@endsection