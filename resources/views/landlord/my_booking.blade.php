@extends('layout.landlord')

@section('content')
    <!---- Different button for every case -------->
    <div style="text-align: center">
        <a id="pending" class="sortButton">@lang('tenant.pending')</a>
        <a id="waiting" class="sortButton">@lang('tenant.waiting')</a>
        <a id="confirmed" class="sortButton">@lang('tenant.confirmed')</a>
        <a id="rejected" class="sortButton">@lang('tenant.rejected')</a>
        <a id="expired" class="sortButton">@lang('tenant.expired')</a>

    </div>

    <div id="multibooking">
        <br>
        @foreach($pack as $p)
            <div class="row">
                <div class="col-md-4">
                    <!--- Mettre photo de la propriété global -->
                    <img src="img/{{$packEstate[$p->idBookingPack]['picture']}} " width="100" height="...">
                </div>
                <div class="col-md-6">
                    <div> @lang('landlord.request_multiBooking') {{$p->idBookingPack}} @lang('landlord.for') {{$title[$p->idBookingPack]}}</div>
                    <div> @lang('landlord.request_by') {{$packPerson[$p->idBookingPack]['login']}} </div>
                    <div> @lang('landlord.period') {{$checkin[$p->idBookingPack]}} @lang('landlord.to') {{$checkout[$p->idBookingPack]}}</div>
                    <div> @lang('landlord.days') {{(strtotime($checkout[$p->idBookingPack])-strtotime($checkin[$p->idBookingPack]))/(60*60*24)}}</div>
                    <div> @lang('landlord.multiBookingCount') {{$bookingCount[$p->idBookingPack]}}</div>

                    <!---- Si Pending ---->
                    <div>
                        <button class='details' id="detailsPack{{$p->idBookingPack}}">
                            @lang('landlord.view_details')
                        </button>
                        @if($status[$p->idBookingPack] == 'pending')
                            <button id="confirmedPack{{$p->idBookingPack}}">
                                @lang('landlord.button_confirmed')
                            </button>
                            <button id="rejectedPack{{$p->idBookingPack}}">
                                @lang('landlord.button_rejected')
                            </button>
                            <p>
                                Il reste :
                                {{$countdown[$p->idBookingPack]['day']}} Jour
                                {{$countdown[$p->idBookingPack]['hour']}} Heure
                                {{$countdown[$p->idBookingPack]['min']}} Min
                                {{$countdown[$p->idBookingPack]['second']}} Seconde
                            </p>
                        @endif
                    </div>
                </div>
                <div class="showDetails" id="showDetails{{$p->idBookingPack}}"></div>
            </div>
        @endforeach
    </div>

    <div id="allbooking">
        <br>

        @foreach($booking as $b)
            <div class="row">
                <div class="col-md-4">
                    <img src="img/{{$estate[$b->idBooking]['picture']}} " width="100" height="...">
                </div>
                <div class="col-md-6">
                    <div> @lang('landlord.request_booking') {{$b->idBooking}} @lang('landlord.for') {{$estate[$b->idBooking]['title']}}</div>
                    <div> @lang('landlord.request_by') <a class="booking{{$b->idBooking}}"
                                                          id="#{{$person[$b->idBooking]['idPerson']}}">{{$person[$b->idBooking]['login']}}</a>
                    </div>
                    <div> @lang('landlord.period') {{$b->checkin}} @lang('landlord.to') {{$b->checkout}}</div>
                    <div> @lang('landlord.days') {{(strtotime($b->checkout)-strtotime($b->checkin))/(60*60*24)}}</div>
                    <div> @lang('landlord.profit') </div>
                    <div> @lang('landlord.guest') {{$b->guest}}</div>
                    @if($b->status == 'pending')
                        <p>
                            Il reste :
                            {{$countdown[$b->idBooking]['day']}} Jour
                            {{$countdown[$b->idBooking]['hour']}} Heure
                            {{$countdown[$b->idBooking]['min']}} Min
                            {{$countdown[$b->idBooking]['second']}} Seconde
                        </p>
                        <div class="col-md-6">
                            <div>
                                <button id="confirmedBooking{{$b->idBooking}}">
                                    @lang('landlord.button_confirmed')
                                </button>
                                <button id="rejectedBooking{{$b->idBooking}}">
                                    @lang('landlord.button_rejected')
                                </button>
                            </div>
                        </div>
                    @elseif($b->status =='waiting')
                        <p>@lang('landlord.is_waiting')<p>
                        <p>
                            Il reste :
                            {{$countdown[$b->idBooking]['day']}} Days
                            {{$countdown[$b->idBooking]['hour']}} Hour
                            {{$countdown[$b->idBooking]['min']}} Min
                            {{$countdown[$b->idBooking]['second']}} Second
                        </p>
                    @elseif($b->status == 'confirmed')
                        <p>@lang('landlord.is_confirmed')</p>
                    @elseif($b->status =='rejected')
                        <p>@lang('landlord.is_rejected')</p>
                    @elseif($b->status =='expired')
                        <p>@lang('landlord.is_expired')</p>
                    @endif
                </div>
            </div>
            <br>
        @endforeach
    </div>

    <!--- Modal Info Tenant -->
    <div id="infoTenant" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a data-dismiss="modal">x</a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <span>@lang('landlord.first_name')</span>
                                <span id="firstName"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.nationality')</span>
                                <span id="nationality"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.studies')</span>
                                <span id="studies"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.school')</span>
                                <span id="school"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.speaks')</span>
                                <span id="speaks"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.about_renter')</span>
                                <span id="about"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.budget')</span>
                                <span id="budget"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.expected_city')</span>
                                <span id="expectedCity"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.expected_in')</span>
                                <span id="expectedIn"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.expected_out')</span>
                                <span id="expectedOut"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>@lang('landlord.more_info')</h4>
                            <p id="moreinfo">@lang('landlord.more_info_advice')</p>
                            <div>
                                <span>@lang('landlord.last_name')</span>
                                <span class="wipeoff" id="lastName"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.phone')</span>
                                <span class="wipeoff" id="phone"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.mail_address')</span>
                                <span class="wipeoff" id="mail"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.full_address')</span>
                                <span class="wipeoff" id="fullAddress"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.birth_date')</span>
                                <span class="wipeoff" id="birthDate"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.birth_place')</span>
                                <span class="wipeoff" id="birthPlace"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.parent_name')</span>
                                <span class="wipeoff" id="parentName"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.parent_address')</span>
                                <span class="wipeoff" id="parentAddress"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.parent_phone')</span>
                                <span class="wipeoff" id="parentPhone"></span>
                            </div>
                            <div>
                                <span>@lang('landlord.parent_mail')</span>
                                <span class="wipeoff" id="parentMail"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-viaflats" data-dismiss="modal">@lang('auth.close')</button>
                </div>
            </div>
        </div>
    </div>

    <div id="rejectCause" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center;">
                    <a data-dismiss="modal">x</a>
                    <h4>@lang('landlord.reject_booking')</h4>
                    <p>@lang('landlord.select_reject_cause')</p>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id' => 'rejectCauseForm']) !!}
                    {!! Form::hidden('idBooking',null,['id'=>'idBooking']) !!}
                    {!! Form::hidden('type',null,['id'=>'type']) !!}
                    <div class="form-group">
                        {!! Form::select('rejectcause',trans('landlord.reject_causes'),null,['id'=> 'selectCause']) !!}
                    </div>
                    <div id="propertyAlreadyBooked" style="display:none;"></div>
                    <div id="dateFit" style="display:none;">
                        <p>@lang('landlord.new_booking')</p>
                        <div id="expected_in_has_error">
                            {!! Form::label(trans('tenant.expected_in')) !!}
                            {!! Form::text('expected_in',null,['class'=>'datepicker','id'=>'expectedNewIn']) !!}
                            <div id="expected_in_error"></div>
                        </div>

                        <div id="expected_out_has_error">
                            {!! Form::label(trans('tenant.expected_out')) !!}
                            {!! Form::text('expected_out',null,['class'=>'datepicker','id'=>'expectedNewOut']) !!}
                            <div id="expected_out_error"></div>
                        </div>
                    </div>
                    <div id="otherCause" class="form-group" style="display:none">
                        {!! Form::textarea('comment',null,['placeholder' => 'Please help us to improve our process by telling us more about this rejection.','id'=>'comment']) !!}
                        <p>Note: The informations entered above will be used only by Viaflats team, the tenant won't
                            have access to them.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit(trans('landlord.submit'),['class'=>"btn btn-viaflats submitCause",'disabled'=>true]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script>

        function showPending() {
            var posting = $.ajax({
                url: 'showPendingBooking',
            })
            posting.done(function (data) {
                $("#allbooking").html("");
                $(data.booking).each(function (index, value) {
                    $("#allbooking").append(
                            '<div class="row">' +
                            '<div class="col-md-4">' +
                            '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                            '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                            '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                            '<div> @lang('landlord.profit') </div>' +
                            '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                            '<div class="col-md-6">' +
                            '<div class="confirmedButton">' +
                            '<button id="confirmed' + value.idBooking + '">' +
                            'Confirmed' +
                            '</button>' +
                            '</div>' +
                            '<div class="rejectedButton">' +
                            '<button id="rejected' + value.idBooking + '">' +
                            'Reject Booking' +
                            '</button>' +
                            '</div>' +
                            'Il reste :' + data.countdown[value.idBooking].day + 'Days' +
                            data.countdown[value.idBooking].hour + ' Hour' +
                            data.countdown[value.idBooking].min + ' Min' +
                            data.countdown[value.idBooking].second + 'Second' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<br>'
                    );
                });
            });
        }

        function showWaiting() {
            var posting = $.ajax({
                url: 'showWaitingBooking',
            });
            posting.done(function (data) {
                $("#allbooking").html("");
                $(data.booking).each(function (index, value) {
                    $("#allbooking").append(
                            '<div class="row">' +
                            '<div class="col-md-4">' +
                            '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                            '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                            '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                            '<div> @lang('landlord.profit') </div>' +
                            '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                            '<div class="col-md-6">' +
                            '<p>@lang('landlord.is_waiting')</p>' +
                            'Il reste :' + data.countdown[value.idBooking].day + 'Days' +
                            data.countdown[value.idBooking].hour + ' Hour' +
                            data.countdown[value.idBooking].min + ' Min' +
                            data.countdown[value.idBooking].second + 'Second' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<br>'
                    );
                });
            });
        }

        function showConfirmed() {
            var posting = $.ajax({
                url: 'showConfirmedBooking',
            })
            posting.done(function (data) {
                $("#allbooking").html("");
                $(data.booking).each(function (index, value) {
                    $("#allbooking").append(
                            '<div class="row">' +
                            '<div class="col-md-4">' +
                            '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                            '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                            '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                            '<div> @lang('landlord.profit') </div>' +
                            '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                            '<div class="col-md-6">' +
                            '<p>@lang('landlord.is_confirmed')</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<br>'
                    );
                });
            });
        }

        function showExpired() {
            var posting = $.ajax({
                url: 'showExpiredBooking',
            });
            posting.done(function (data) {
                $("#allbooking").html("");
                $(data.booking).each(function (index, value) {
                    $("#allbooking").append(
                            '<div class="row">' +
                            '<div class="col-md-4">' +
                            '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                            '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                            '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                            '<div> @lang('landlord.profit') </div>' +
                            '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                            '<div class="col-md-6">' +
                            '<p>@lang('landlord.is_expired')</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<br>'
                    );
                });
            });
        }

        function showRejected() {
            var posting = $.ajax({
                url: 'showRejectedBooking',
            });
            posting.done(function (data) {
                $("#allbooking").html("");
                $(data.booking).each(function (index, value) {
                    $("#allbooking").append(
                            '<div class="row">' +
                            '<div class="col-md-4">' +
                            '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                            '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                            '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                            '<div> @lang('landlord.profit') </div>' +
                            '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                            '<div class="col-md-6">' +
                            '<p>@lang('landlord.is_rejected')</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<br>'
                    );
                });
            });
        }

        function showAll() {

            var posting = $.ajax({
                url: 'showMyBooking',
            });
            posting.done(function (data) {
                $("#allbooking").html("");
                $(data.booking).each(function (index, value) {
                    switch (value.status) {
                        case 'pending':
                            $("#allbooking").append(
                                    '<div class="row">' +
                                    '<div class="col-md-4">' +
                                    '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                                    '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                                    '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                                    '<div> @lang('landlord.profit') </div>' +
                                    '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div class="confirmedButton">' +
                                    '<button id="confirmed' + value.idBooking + '">' +
                                    'Confirmed' +
                                    '</button>' +
                                    '</div>' +
                                    '<div class="rejectedButton">' +
                                    '<button id="rejected' + value.idBooking + '">' +
                                    'Reject Booking' +
                                    '</button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br>'
                            );
                            break;
                        case 'waiting':
                            $("#allbooking").append(
                                    '<div class="row">' +
                                    '<div class="col-md-4">' +
                                    '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                                    '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                                    '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                                    '<div> @lang('landlord.profit') </div>' +
                                    '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                                    '<div class="col-md-6">' +
                                    '<p>@lang('landlord.is_waiting')</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br>'
                            );
                            break;
                        case 'confirmed':
                            $("#allbooking").append(
                                    '<div class="row">' +
                                    '<div class="col-md-4">' +
                                    '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                                    '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                                    '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                                    '<div> @lang('landlord.profit') </div>' +
                                    '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                                    '<div class="col-md-6">' +
                                    '<p>@lang('landlord.is_confirmed')</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br>'
                            );
                            break;
                        case 'rejected':
                            $("#allbooking").append(
                                    '<div class="row">' +
                                    '<div class="col-md-4">' +
                                    '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                                    '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                                    '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                                    '<div> @lang('landlord.profit') </div>' +
                                    '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                                    '<div class="col-md-6">' +
                                    '<p>@lang('landlord.is_rejected')</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br>'
                            );
                            break;
                        case 'expired' :
                            $("#allbooking").append(
                                    '<div class="row">' +
                                    '<div class="col-md-4">' +
                                    '<img src="img/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request_booking')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
                                    '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '" id="#' + data.person[index].idPerson + '">' + data.person[index].login + '</a></div>' +
                                    '<div> @lang('landlord.period')' + value.checkin + '@lang('landlord.to')' + value.checkout + '</div>' +
                                    '<div> @lang('landlord.profit') </div>' +
                                    '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                                    '<div class="col-md-6">' +
                                    '<p>@lang('landlord.is_expired')</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br>'
                            );
                            break;
                    }
                });
            });
        }

        function showMultiBooking(status) {
            var posting = $.ajax({
                url: 'showMultiBooking',
                data: {
                    'status': status,
                }
            });
            posting.done(function (data) {
                $('#multibooking').html('');
                if (data.empty == false) {
                    $(data.pack).each(function (index, value) {
                        $('#multibooking').append(
                                '<div class="row">' +
                                '<div class="col-md-4">' +
                                '<img src="img/' + data.estate[value.idBookingPack].picture + '" width="100" height="...">' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                '<div> @lang('landlord.request_multiBooking') ' + value.idBookingPack + ' @lang('landlord.for') ' + data.title[value.idBookingPack] + '</div>' +
                                '<div> @lang('landlord.request_by')' + data.person[value.idBookingPack].login + '</div>' +
                                '<div> @lang('landlord.period') ' + data.checkin[value.idBookingPack] + ' @lang('landlord.to') ' + data.checkout[value.idBookingPack] + ' </div>' +
                                '<div> @lang('landlord.days') </div>' +
                                '<div> @lang('landlord.multiBookingCount') ' + data.bookingCount[value.idBookingPack] + '</div>' +
                                '</div>' +
                                '</div>'
                        );
                        switch (data.status[value.idBookingPack]) {
                            case 'pending' :
                                $('#multibooking').append(
                                        '<p> Il reste :' +
                                        data.countdown[value.idBookingPack]['day'] + 'Days' +
                                        data.countdown[value.idBookingPack]['hour'] + 'Hour' +
                                        data.countdown[value.idBookingPack]['min'] + 'Min' +
                                        data.countdown[value.idBookingPack]['second'] + 'Second' +
                                        '</p>' +
                                        '<button id="confirmedPack' + value.idBookingPack + '">@lang('landlord.button_confirmed')</button>' +
                                        '<button id="rejectedPack' + value.idBookingPack + '">@lang('landlord.button_rejected')</button>' +
                                        '<button class="details" id="detailsPack' + value.idBookingPack + '"> @lang('landlord.view_details') </button>' +
                                        '<div class="showDetails" id="showDetails' + value.idBookingPack + '"></div>' +
                                        '<br>'
                                );
                                break;
                            case 'waiting':
                                $('#multibooking').append(
                                        '<p> @lang('landlord.is_waiting_multi')</p>' +
                                        '<p> Il reste :' +
                                        data.countdown[value.idBookingPack]['day'] + 'Days' +
                                        data.countdown[value.idBookingPack]['hour'] + 'Hour' +
                                        data.countdown[value.idBookingPack]['min'] + 'Min' +
                                        data.countdown[value.idBookingPack]['second'] + 'Second' +
                                        '</p>' +
                                        '<button class="details" id="detailsPack' + value.idBookingPack + '"> @lang('landlord.view_details')</button>' +
                                        '<div class="showDetails" id="showDetails' + value.idBookingPack + '"></div>' +
                                        '<br>'
                                );
                                break;
                            case 'confirmed' :
                                $('#multibooking').append(
                                        '<p> @lang('landlord.is_confirmed_multi')</p>' +
                                        '<button class="details" id="detailsPack' + value.idBookingPack + '"> @lang('landlord.view_details') </button>' +
                                        '<div class="showDetails" id="showDetails' + value.idBookingPack + '"></div>' +
                                        '<br>'
                                );
                                break;
                            case 'expired' :
                                $('#multibooking').append(
                                        '<p> @lang('landlord.is_expired')</p>' +
                                        '<button class="details" id="detailsPack' + value.idBookingPack + '"> @lang('landlord.view_details') </button>' +
                                        '<div class="showDetails" id="showDetails' + value.idBookingPack + '"></div>' +
                                        '<br>'
                                );
                                break;
                            case 'rejected' :
                                $('#multibooking').append(
                                        '<p> @lang('landlord.is_rejected')</p>' +
                                        '<button class="details" id="detailsPack' + value.idBookingPack + '"> @lang('landlord.view_details') </button>' +
                                        '<div class="showDetails" id="showDetails' + value.idBookingPack + '"></div>' +
                                        '<br>'
                                );
                                break;
                        }

                    });
                }
            });
        }

        function refresh() {
            var idSelected = $('.isSelected').attr('id');
            switch (idSelected) {
                case 'pending':
                    showMultiBooking('pending');
                    showPending();
                    break;
                case 'waiting':
                    showMultiBooking('waiting');
                    showWaiting();
                    break;
                case 'confirmed':
                    showMultiBooking('confirmed');
                    showConfirmed();
                    break;
                case 'rejected':
                    showMultiBooking('rejected');
                    showRejected();
                    break;
                case 'expired' :
                    showMultiBooking('expired');
                    showExpired();
                    break;
                default :
                    showMultiBooking('all');
                    showAll();
            }
        }

        $('#pending').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showMultiBooking('all');
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showMultiBooking('pending');
                showPending();
            }
        });

        $('#waiting').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showMultiBooking('all');
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showMultiBooking('waiting');
                showWaiting();
            }
        });

        $('#confirmed').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showMultiBooking('all');
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showMultiBooking('confirmed');
                showConfirmed();
            }
        });

        $('#rejected').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showMultiBooking('all');
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showMultiBooking('rejected');
                showRejected();
            }
        });

        $('#expired').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showMultiBooking('all');
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showMultiBooking('expired');
                showExpired();
            }
        });

        $(document).on('click', "[id^='confirmedBooking']", function (event) {
            event.preventDefault();
            var idB = $(this).attr('id').replace('confirmedBooking', '');
            var posting = $.ajax({
                url: 'confirmBooking',
                data: {
                    'idBooking': idB
                }
            });
            posting.done(function () {
                refresh();
            });
        });

        $(document).on('click', "[id^='#']", function (event) {
            event.preventDefault();
            var idP = $(this).attr('id').replace('#', '');
            var idB = $(this).attr('class').replace('booking', '');
            var posting = $.ajax({
                url: 'showInfoTenant',
                data: {
                    'idP': idP,
                    'idBooking': idB,
                }
            });
            posting.done(function (data) {
                $("#moreinfo").show();
                $("#firstName").html(data.person.first_name);
                $("#nationality").html(data.tenant.nationality);
                $("#school").html(data.tenant.school_company);
                $("#studies").html(data.tenant.work_studies);
                $("#speaks").html(data.tenant.spoken_languages);
                $("#about").html(data.tenant.about);
                $("#budget").html(data.tenant.budget_max);
                $("#expectedCity").html(data.expected_city);
                $("#expectedIn").html(data.tenant.expected_in);
                $("#expectedOut").html(data.tenant.expected_out);
                $(".wipeoff").html('');
                if (data.booking == 'confirmed') {
                    $("#moreinfo").hide();
                    $("#lastName").html(data.person.last_name);
                    $("#phone").html(data.person.phone);
                    $("#mail").html(data.person.email);
                    $("#fullAddress").html(data.address.street_number + data.address.street + data.address.zip + data.address.city + data.address.country);
                    $("#birthDate").html(data.tenant.birth_date);
                    $("#birthPlace").html(data.tenant.birth_place);
                    $("#parentName").html(data.parent.first_name + ' ' + data.parent.last_name);
                    $("#parentAddress").html(data.address_p.street_number + data.address_p.street + data.address_p.zip + data.address_p.city + data.address_p.country);
                    $("#parentPhone").html(data.parent.phone);
                    $("#parentMail").html(data.parent.email);
                }
                $("#infoTenant").modal();
            });
        });

        $(document).on('click', "[id^='rejectedBooking']", function (event) {
            var idBooking = $(this).attr('id').replace('rejectedBooking', '');
            $('#type').val('booking');
            $('#idBooking').val(idBooking);
            $("#rejectCause").modal();
        });

        $(document).on('click', "[id^='rejectedPack']", function (event) {
            var idBooking = $(this).attr('id').replace('rejectedPack', '');
            $('#type').val('pack');
            $('#idBooking').val(idBooking);
            $("#rejectCause").modal();
        });

        $(document).on('submit', "#rejectCauseForm", function (event) {
            event.preventDefault();
            var $form = $('#rejectCauseForm'),
                    url = "rejectBooking";
            var posting = $.ajax({
                method: "POST",
                url: url,
                data: {
                    'data': $form.serialize(),
                    "_token": "{{ csrf_token() }}"
                }
            });
            posting.done(function (data) {
                if (data.fail) {
                    $('div').each(function () {
                        if ($(this).hasClass('required')) {
                            $(this).empty();
                        }
                    });
                    $.each(data.errors, function (index, value) {
                        var errorMsg = '#' + index + '_error';
                        var errorDiv = '#' + index + '_has_error';
                        $(errorMsg).addClass('required');
                        $(errorMsg).empty().append(value);
                        $(errorDiv).addClass('error');
                        $(errorDiv).addClass('has-error');
                    });
                    $('#rejectCause').modal('show');
                } else {
                    $('div').each(function () {
                        if ($(this).hasClass('required')) {
                            $(this).empty();
                        }
                    });
                    $('#rejectCause').modal('hide');
                    refresh();
                }
            });
        });

        $(document).on('click', "[id^='detailsPack']", function (event) {
            var idP = $(this).attr('id').replace('detailsPack', '');
            event.preventDefault();
            if ($(this).hasClass('detailSelected')) {
                $('.details').each(function () {
                    $(this).removeClass("detailSelected")
                });
                $('.showDetails').html('');
            } else {
                $('.details').each(function () {
                    $(this).removeClass("detailSelected")
                });
                $('.showDetails').html('');
                $(this).addClass('detailSelected');
                var posting = $.ajax({
                    url: 'DetailsBookingPack',
                    data: {
                        'idPack': idP,
                    }
                });
                posting.done(function (data) {
                    $(data.booking).each(function (index, value) {
                        $('#showDetails' + idP).append('<div class=row>' +
                                '<div class="col-md-4">' +
                                '<img src="property/' + data.estate[value.idBooking].picture + ' " width="100" height="...">' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                '<div> @lang('landlord.request_booking') ' + value.idBooking + ' @lang('landlord.for') ' + data.estate[value.idBooking].title + ' </div>' +
                                '<div> @lang('landlord.request_by') <a class="booking' + value.idBooking + '"  id="#' + data.person[value.idBooking].idPerson + '">' + data.person[value.idBooking].login + '</a> </div>' +
                                '<div> @lang('landlord.profit') </div>' +
                                '<div> @lang('landlord.guest')' + value.guest + '</div>' +
                                '</div>' +
                                '</div>'
                        );
                    });
                    console.log(data.booking);
                });
            }
        });

        $(document).on('click', "[id^='confirmedPack']", function (event) {
            event.preventDefault();
            var idP = $(this).attr('id').replace('confirmedPack', '');
            var posting = $.ajax({
                url: 'confirmBookingPack',
                data: {
                    'idPack': idP,
                }
            });
            posting.done(function (data) {
                refresh();
            });
        });

        $("#rejectCauseForm").on('change', function () {
            if ($("#selectCause").val() != 'null') {
                if ($("#selectCause").val() == 'Property already booked') {
                    $('#otherCause').hide();
                    $('#dateFit').hide();
                    $('.submitCause').attr('disabled', false);
                } else if ($("#selectCause").val() == 'Dates don\'t fit') {
                    $('#dateFit').show();
                    $('#otherCause').hide();
                    if (($("#expectedNewIn").val() != "") && ($('#expectedNewOut').val() != "")) {
                        $('.submitCause').attr('disabled', false);
                    } else {
                        $('.submitCause').attr('disabled', true);
                    }
                } else {
                    $('#dateFit').hide();
                    $('#otherCause').show();
                    if ($('#comment').val() != '') {
                        $('.submitCause').attr('disabled', false);
                    } else {
                        $('.submitCause').attr('disabled', true);
                    }
                }
            } else {
                $('#otherCause').hide();
                $('#dateFit').hide();
                $('.submitCause').attr('disabled', true);
            }
        });

        //Date Picker
        $(function () {
            $(".datepicker").datepicker();
        });
    </script>
@endsection