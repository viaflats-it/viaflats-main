@extends('layout.landlord')

@section('contenu')
    <!---- Different button for every case -------->
    <div style="text-align: center">
        <a id="pending" class="sortButton">@lang('tenant.pending')</a>
        <a id="waiting" class="sortButton">@lang('tenant.waiting')</a>
        <a id="confirmed" class="sortButton">@lang('tenant.confirmed')</a>
        <a id="rejected" class="sortButton">@lang('tenant.rejected')</a>
        <a id="expired" class="sortButton">@lang('tenant.expired')</a>

    </div>


    <div id="allbooking">
        <br>
        @foreach($booking as $b)
            @foreach($estate as $e)
                @if($b->idEstate == $e->idEstate)
                    @foreach($tenant as $t)
                        @if($t->idTenant == $b->idTenant)
                            @foreach($person as $p)
                                @if($p->idPerson == $t->idPerson)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="property/{{$e->picture}} " width="100" height="...">
                                        </div>
                                        <div class="col-md-6">
                                            <div> @lang('landlord.request') {{$b->idBooking}} @lang('landlord.for') {{$e->title}}</div>
                                            <div> @lang('landlord.request_by') <a class="booking{{$b->idBooking}}"
                                                                                  id="#{{$p->idPerson}}">{{$p->login}}</a>
                                            </div>
                                            <div> @lang('landlord.period') {{$b->checkin}} @lang('landlord.to') {{$b->checkout}}</div>
                                            <div> @lang('landlord.days') {{(strtotime($b->checkout)-strtotime($b->checkin))/(60*60*24)}}</div>
                                            <div> @lang('landlord.profit') {{strtotime($b->creation_date)}} </div>

                                            <div> @lang('landlord.guest') {{$b->guest}}</div>
                                            @if($b->status == 'pending')
                                                <p>
                                                    Il reste {{$b->creation_date}}
                                                </p>
                                                <div class="col-md-6">
                                                    <div class="confirmedButton">
                                                        <button id="confirmed{{$b->idBooking}}">
                                                            Confirmed
                                                        </button>
                                                    </div>
                                                    <div class="rejectedButton">
                                                        <button id="rejected{{$b->idBooking}}">
                                                            Reject Booking
                                                        </button>
                                                    </div>
                                                </div>
                                            @elseif($b->status =='waiting')
                                                <div class="col-md-6">
                                                    <p>@lang('landlord.is_waiting')</p>
                                                </div>
                                            @elseif($b->status == 'confirmed')
                                                <div class="col-md-6">
                                                    <p>@lang('landlord.is_confirmed')</p>
                                                </div>
                                            @elseif($b->status =='rejected')
                                                <div class="col-md-6">
                                                    <p>@lang('landlord.is_rejected')</p>
                                                </div>
                                            @elseif($b->status =='expired')
                                                <div class="col-md-6">
                                                    <p>@lang('landlord.is_expired')</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
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
                            '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                            '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                            '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                            '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                            '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                            '</div>' +
                            '<div class="col-md-6">' +
                            '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                                    '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                                    '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                                    '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                                    '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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
                                    '<img src="property/' + data.estate[index].picture + '" width="100" height="...">' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div> @lang('landlord.request')' + value.idBooking + ' @lang('landlord.for') ' + data.estate[index].title + '</div>' +
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

        function refresh() {
            var idSelected = $('.isSelected').attr('id');
            switch (idSelected) {
                case 'pending':
                    showPending();
                    break;
                case 'waiting':
                    showWaiting();
                    break;
                case 'confirmed':
                    showConfirmed();
                    break;
                case 'rejected':
                    showRejected();
                    break;
                case 'expired' :
                    showExpired();
                    break;
                default :
                    showAll();
            }
        }

        $('#pending').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showPending();
            }
        });

        $('#waiting').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showWaiting();
            }
        });

        $('#confirmed').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showConfirmed();
            }
        });

        $('#rejected').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showRejected();
            }
        });

        $('#expired').on('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('isSelected')) {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                showAll();
            } else {
                $('.sortButton').each(function () {
                    $(this).removeClass("isSelected")
                });
                $(this).addClass('isSelected');
                showExpired();
            }
        });

        $("#allbooking").on("click", "[id^='#']", function (event) {
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

        $("#allbooking").on('click', "[id^='confirmed']", function (event) {
            event.preventDefault();
            var idB = $(this).attr('id').replace('confirmed', '');
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

        $("#allbooking").on('click', "[id^='rejected']", function () {
            var idBooking = $(this).attr('id').replace('rejected', '');
            $('#idBooking').val(idBooking);
            $("#rejectCause").modal();
        });

        $("#allbooking").on('click',"[id^='info']",function(event){
            var idBooking = $(this).attr('id').replace('info', '');
            var posting = $.ajax({
                url:'viewDetails',
                data:{
                    'idBooking' : idBooking,
                }
            });
            posting.done(function(data){
                $(this).addClass('detailsSelected');
                $('#details'+data.booking.idBooking).append('hoi');
                console.log(data);
            })
        });

        $("#rejectCauseForm").on('submit', function (event) {
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