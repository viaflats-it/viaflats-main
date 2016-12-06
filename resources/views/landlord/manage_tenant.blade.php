@extends('layout.landlord')

@section('content')

    @foreach($estates as $estate)
        <div class="row">
            <div class="col-md-2">
                <img src="img/{{$estate->picture}} " width="100" height="...">
            </div>
            <div class="col-md-6">
                <div> Title : {{$estate->title}}  </div>
                <div> Status : {{$estate->status}}</div>
                @if($status[$estate->idEstate] == 'Booked')
                    @if($TypeTenant[$estate->idEstate])
                        <div> {{$status[$estate->idEstate]}} until <span
                                    id="checkoutDate{{$estate->idEstate}}">{{$DCheckout[$estate->idEstate]}}</span> from <a
                                    id="#{{$Tenant[$estate->idEstate]->idPerson}}">
                                {{$Tenant[$estate->idEstate]->login}}
                            </a></div>
                        <button id="check{{$booking[$estate->idEstate]->idBooking}}"> Change checkout</button>
                    @else
                        <div> {{$status[$estate->idEstate]}} until <span
                                    id="checkoutDate{{$estate->idEstate}}">{{$DCheckout[$estate->idEstate]}}</span> from <a
                                    id="FB{{$foreignB[$estate->idEstate]->idForeignBooking}}">
                                {{$foreignB[$estate->idEstate]->first_name}}
                            </a></div>
                        <button id="CF{{$foreignB[$estate->idEstate]->idForeignBooking}}"> Change checkout</button>
                    @endif
                @elseif($status[$estate->idEstate] == 'Free')
                    <div> {{$status[$estate->idEstate]}}</div>
                @else
                    <div> {{$status[$estate->idEstate]}} {{$freeDate[$estate->idEstate]}}</div>
                @endif
                <button class="addtenant" id="addtenant{{$estate->idEstate}}"> Add Tenant</button>
                <button> Show All Tenant for 1 year</button>
            </div>
        </div>
        <br>
    @endforeach

    <!--- Modal Add Tenant -->
    <div id="showaddtenant" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add Tenant </h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'addTenant','id'=>'addTenantForm']) !!}
                    {!! Form::hidden('idEstate',null,['id'=>'idEstate']) !!}
                    <div id="ErrorMessage"></div>
                    <div class="form-group row" id="first_name_has_error">
                        <div class="col-md-6">
                            {!! Form::label(trans('landlord.first_name')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('first_name',null,['class'=>'formAddTenant']) !!}
                        </div>
                        <div id="first_name_error"></div>
                    </div>
                    <div class="form-group row" id="age_has_error">
                        <div class="col-md-6">
                            {!! Form::label(trans('landlord.age')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('age',null,['class'=>'formAddTenant']) !!}
                        </div>
                        <div id="age_error"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6" id="student">
                            {!! Form::label('student',trans('tenant.student')) !!}
                            {!! Form::radio('student','1',true) !!}
                        </div>
                        <div class="col-md-6" id='worker'>
                            {!! Form::label('student',trans('tenant.worker')) !!}
                            {!! Form::radio('student','0') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('gender',trans('tenant.girl')) !!}
                            {!! Form::radio('gender','Girl',true) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('gender',trans('tenant.boy')) !!}
                            {!! Form::radio('gender','Boy') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6" id="expected_in_has_error">
                            {!! Form::label(trans('tenant.expected_in')) !!}
                            {!! Form::text('expected_in',null,['class'=>'datepicker formAddTenant']) !!}
                            <div id="expected_in_error"></div>
                        </div>
                        <div class="col-md-6" id="expected_out_has_error">
                            {!! Form::label(trans('tenant.expected_out')) !!}
                            {!! Form::text('expected_out',null,['class'=>'datepicker formAddTenant']) !!}
                            <div id="expected_out_error"></div>
                        </div>
                    </div>
                    <div class="form-group row" style="text-align: center">
                        {!! Form::label(trans('landlord.addComment')) !!}
                        <br>
                        {!! Form::textarea('comment') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit(trans('landlord.submit',['class'=>'btn submitTenant'],'disabled')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
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

    <div id="infoForeignB" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a data-dismiss="modal">x</a>
                </div>
                <div class="modal-body">
                    <div>
                        <span>@lang('landlord.first_name')</span>
                        <span id="firstNameFB"></span>
                    </div>
                    <div>
                        <span>@lang('landlord.age')</span>
                        <span id="ageFB"></span>
                    </div>
                    <div>
                        <span>@lang('landlord.studies')</span>
                        <span id="studentFB"></span>
                    </div>
                    <div>
                        <span>@lang('landlord.gender')</span>
                        <span id="genderFB"></span>
                    </div>
                    <div>
                        <span> Comment </span>
                        <span id="comment"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-viaflats" data-dismiss="modal">@lang('auth.close')</button>
                </div>
            </div>
        </div>
    </div>

    <div id="changeCheck" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['id'=>'changeCheckForm']) !!}
                <div class="modal-header">
                    <h4> @lang('landlord.changeCheckout')</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('idBooking',null,['id'=>'idBooking']) !!}
                    {!! Form::hidden('type',null,['id'=>'Type']) !!}
                    <div class="form-group" id="date_has_error">
                        {!! Form::label('Choose the new date' ) !!}
                        {!! Form::text('date',null,['class'=>'datepicker']) !!}
                        <div id="date_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit(trans('landlord.submit'))  !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script>

        $("#addTenantForm").on('submit', function (event) {
            event.preventDefault();
            var $form = $('#addTenantForm'),
                    url = "addTenant";
            var posting = $.ajax({
                method: "POST",
                url: url,
                data: {
                    'data': $form.serialize(),
                    "_token": "{{ csrf_token() }}"
                }
            });
            posting.done(function (data) {
                $('#ErrorMessage').html("");
                $('div').each(function () {
                    if ($(this).hasClass('required')) {
                        $(this).empty();
                    }
                });
                if (data.fail) {
                    $.each(data.errors, function (index, value) {
                        var errorMsg = '#' + index + '_error';
                        var errorDiv = '#' + index + '_has_error';
                        $(errorMsg).addClass('required');
                        $(errorMsg).empty().append(value);
                        $(errorDiv).addClass('error');
                        $(errorDiv).addClass('has-error');
                    });
                    $('#ErrorMessage').append(data.msg_error);
                    $('#showaddtenant').modal('show');
                } else {
                    $('#showaddtenant').modal('hide');
                }
            });
        });

        $(".addtenant").on('click', function () {
            var idEstate = $(this).attr('id').replace('addtenant', '');
            $('#idEstate').val(idEstate);
            $("#showaddtenant").modal();
        });

        $(document).on('click', "[id^='#']", function (event) {
            event.preventDefault();
            var idP = $(this).attr('id').replace('#', '');
            var posting = $.ajax({
                url: 'showInfoTenant',
                data: {
                    'idP': idP,
                    'idBooking': 'null',
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
                if (data.status == 'confirmed') {
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

        $(document).on('click', "[id^='check']", function () {
            var idB = $(this).attr('id').replace('check', '');
            $('#idBooking').val(idB);
            $('#Type').val('booking');
            $("#changeCheck").modal();
        });

        $(document).on('click', "[id^='CF']", function () {
            var idB = $(this).attr('id').replace('CF', '');
            $('#idBooking').val(idB);
            $('#Type').val('foreign');
            $("#changeCheck").modal();
        });

        $(document).on('click',"[id^='FB']",function(event){
            event.preventDefault();
            var idFB = $(this).attr('id').replace('FB', '');
            var posting = $.ajax({
                url: 'showInfoForeignBooking',
                data: {
                    'idFB': idFB,
                }
            });
            posting.done(function(data){
                $('#firstNameFB').html(data.FBooking['first_name']);
                $('#ageFB').html(data.FBooking['age']);
                $('#studentFB').html(data.FBooking['student']);
                $('#genderFB').html(data.FBooking['gender']);
                $('#comment').html(data.FBooking['comment']);
                $("#infoForeignB").modal();
                console.log(data);
            });
        });

        $("#changeCheckForm").on('submit', function (event) {
            event.preventDefault();
            var $form = $('#changeCheckForm');
                    url = "changeCheckout";
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
                    $.each(data.errors, function (index, value) {
                        var errorMsg = '#' + index + '_error';
                        var errorDiv = '#' + index + '_has_error';
                        $(errorMsg).addClass('required');
                        $(errorMsg).empty().append(value);
                        $(errorDiv).addClass('error');
                        $(errorDiv).addClass('has-error');
                    });
                    $('#changeCheck').modal('show');
                } else {
                    $('#changeCheck').modal('hide');
                    $("#checkoutDate"+data.idEstate).html(data.date);
                }
            });
        });

        //Date Picker
        $(document).ready(function () {
            $(".datepicker").datepicker();
        });

    </script>
@endsection