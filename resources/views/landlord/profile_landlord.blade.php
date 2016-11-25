@extends('layout.landlord')

@section('content')

    <div class="row profile" id="changeProfile">
        <div class="col-md-12">
            <h3>@lang('landlord.profile')</h3>
            <div class="row ">
                <form id="updateProfile" action="profile" method="post">
                    <div class="col-md-6">
                        <div id="successMessageProfile"></div>
                        <div class="col-md-6">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group" id="first_name_has_error">
                                <label for="first_name">@lang('landlord.first_name')</label>
                                <input type="text" name="first_name" id="first_name"
                                       class="form-control"
                                       value="{{Auth::user()->first_name ? Auth::user()->first_name: '' }}"/>
                                <div id="first_name_error"></div>


                            </div>

                            <div class="form-group" id="last_name_has_error">
                                <label for="last_name">@lang('landlord.last_name')</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                       value="{{Auth::user()->last_name ? Auth::user()->last_name: '' }}"/>
                                <div id="last_name_error"></div>

                            </div>

                            <div class="form-group" id="email_has_error">
                                <label for="email">@lang('landlord.email')</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{Auth::user()->email ? Auth::user()->email: '' }}"/>
                                <div id="email_error"></div>

                            </div>
                            <div class="form-group" id="phone_has_error">
                                <label for="phone">@lang('landlord.phone')</label>
                                {{--<div style="display:flex;">--}}
                                    {{--<div class="input-group" style="width: 35%">--}}
                                        {{--<div class="input-group-addon">+</div>--}}
                                        {{--<input type="text" class="form-control" name="phone_indicator"--}}
                                               {{--id="phone_indicator"--}}
                                               {{--value="{{Auth::user()->phone_indicator ? Auth::user()->phone_indicator: '' }}">--}}
                                    {{--</div>--}}
                                    {{--<input type="tel" name="phone" id="phone" class="form-control"--}}
                                           {{--style="width: 65%; float: right"--}}
                                           {{--value="{{Auth::user()->phone ? Auth::user()->phone: ''}}"/>--}}
                                {{--</div>--}}
                                <input type="tel" class="form-control" id="phone"
                                       value="{{Auth::user()->phone ? Auth::user()->phone: ''}}" />
                                <div id="phone_error"></div>
                                <div id="phone_indicator_error"></div>


                                </br>
                                <button type="submit" class="btn  btn-viaflats">@lang('landlord.update')</button>

                            </div>

                        </div>

                    </div>
                    <div class="col-md-3 col-md-push-1">
                        <img class="profilPic" src="profilepics/{{$landlord->profile_picture}}">
                        <div class="form-group">
                            {!! Form::open(['url' => 'landlord_picture', 'files' => true ]) !!}
                            {!! Form::file('image') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('landlord.send'), ['class'=>'btn btn-viaflats']) !!}
                            {!! Form::close() !!}
                        </div>

                    </div>
                </form>
            </div>
        </div>


    </div>

    </br>
    <div class="row profile" id="changePassword">
        <div class="col-md-12 ">
            <h3>@lang('landlord.changePassword')</h3>
            <div id="successMessagePassword"></div>
            <div class="row">
                <div class="col-md-3">
                    {!! Form::open(['id'=>'updatePassword', 'url' => 'updatePassword']) !!}
                    <div class="form-group" id="actual_password_has_error">

                        {!! Form::label('actual_password', trans('landlord.actual_password')) !!}
                        {!! Form::password('actual_password', ['class' => 'form-control']) !!}
                        <div id="actual_password_error"></div>

                    </div>
                    <div class="form-group" id="new_password_has_error">

                        {!! Form::label('new_password', trans('landlord.new_password')) !!}
                        {!! Form::password('new_password', ['class' => 'form-control']) !!}
                        <div id="new_password_error"></div>

                        {!! Form::label('new_password_confirmation', trans('landlord.new_password_confirmation')) !!}
                        {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                        <div id="new_password_confirmation_error"></div>

                    </div>
                    {!! Form::submit(trans('landlord.update'), ['class'=>'btn btn-viaflats']) !!}
                    {!! Form::close() !!}


                </div>
            </div>


        </div>
    </div>


    <div class="row profile" id="changeInformation">
        <div class="col-md-12">
            <h3>@lang('landlord.moreInformation')</h3>
            <div id="successMessage"></div>

            <div class="row">
                <div class="col-md-3">
                    {!! Form::open(['id' => 'updateInformation', 'url' => 'updateInformation']) !!}
                    <div class="form-group">
                        {!! Form::label('about' , trans('landlord.about')) !!}
                        {!! Form::textarea('about', $landlord->about, ['class' => 'form-control', 'size' => '30x5']) !!}
                    </div>

                    @if ($errors->has('about'))
                        <span class="help-block">
                                        <strong>{{$errors->first('about')}}</strong>
                                </span>
                    @endif
                    <div class="form-group">
                        {!! Form::label('contact_preference' , trans('landlord.contact_preference')) !!}
                        </br>
                        {!! Form::radio('contact_preference', '2', $landlord->contact_preference == 2 ? 'true' : '') !!}
                        {!! Form::label(trans('landlord.email')) !!}
                        </br>
                        {!! Form::radio('contact_preference', '1',  $landlord->contact_preference == 1 ? 'true' : '') !!}
                        {!! Form::label(trans('landlord.phone')) !!}
                        </br>
                        {!! Form::radio('contact_preference', '0',  $landlord->contact_preference == 0 ? 'true' : '') !!}
                        {!! Form::label(trans('landlord.none')) !!}
                        <div id="contact_preference"></div>

                    </div>
                    {{--<div class="form-group">--}}
                    {{--{!! Form::label('availabilities' , trans('landlord.availabilities')) !!}--}}

                    {{--{!! Form::select('date', $weekday, null, ['class' => 'form-control']) !!}--}}
                    {{--@if ($errors->has('date') )--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{$errors->first('date')}}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    {{--<div style="display:inline-flex">--}}
                    {{--{!! Form::time('time_start', null, ['class' => 'form-control']) !!}--}}
                    {{--{!! Form::time('time_end', null , ['class' => 'form-control']) !!}--}}
                    {{--</div>--}}
                    {{--@if($errors->has('time_start'))--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{$errors->first('time_start')}}</strong>--}}
                    {{--</span>--}}
                    {{--@elseif($errors->has('time_end'))--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{$errors->first('time_end')}}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}

                </div>
                <div class="col-md-3 col-md-push-1 ">
                    <div class="form-group">
                        {!! Form::label('corporate' , trans('landlord.corporate')) !!}
                        </br>
                        {!! Form::radio('corporate', '0',  $landlord->corporate == 0 ? 'true' : '') !!}
                        {!! Form::label(trans('landlord.private')) !!}

                        </br>
                        {!! Form::radio('corporate', '1', $landlord->corporate == 1 ? 'true' : '') !!}
                        {!! Form::label(trans('landlord.corporate')) !!}


                    </div>
                    <div class="form-group">
                        {!! Form::label('company_web' ,trans('landlord.company_web')) !!}
                        {!! Form::text('company_web', $landlord->company_website , ['class' => 'form-control']) !!}
                    </div>

                </div>
            </div>

            {!! Form::submit(trans('landlord.update'), ['class' => 'btn btn-viaflats']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <script>
        $("#phone").intlTelInput();
    </script>
    <script>
        /*UPDATE PROFILES */
        function saveProfile() {

            var $form = $("#updateProfile"),
                    url = "profile",
                    phone = $('#phone').intlTelInput('getNumber');

            var posting = $.ajax({
                method: "POST",
                url: url,
                data: {
                    'data': $form.serialize(),
                    "phone" : phone,
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
                        $(errorDiv).addClass('has-error');
                    });
                    $('#successMessageProfile').empty();
                } else {

                    var successContent = '<div class="alert alert-success"><span>Update Completed Successfully</span></div>';
                    $('#successMessageProfile').html(successContent);
                }

            });


        }


        /*UPDATE PASSWORD */

        $("#updatePassword").submit(function (event) {
            event.preventDefault();

            var $form = $(this),
                    url = "updatePassword";

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
                        $(errorMsg).addClass('required');
                        $(errorMsg).empty().append(value);
                        if (index == "new_password_confirmation") {
                            index = "new_password";
                        }
                        var errorDiv = '#' + index + '_has_error';
                        $(errorDiv).addClass('has-error');
                    });

                    if (data.errors_auth) {
                        var errorMsg = '#actual_password_error';
                        $(errorMsg).addClass('required');
                        $(errorMsg).empty().append(data.errors_auth);
                        $('#actual_password_has_error').addClass('has-error');
                    }
                    $('#successMessagePassword').empty();
                } else {

                    var successContent = '<div class="alert alert-success"><span>Update Completed Successfully</span></div>';
                    $('#successMessagePassword').html(successContent);
                }

            });


        });

        /* UPDATE INFORMATION */
        function saveInformation() {

            var $form = $('#updateInformation'),
                    url = "updateInformation";

            console.log($form);
            var posting = $.ajax({
                method: "POST",
                url: url,
                data: {
                    'data': $form.serialize(),
                    "_token": "{{ csrf_token() }}"
                }
            });

            posting.done(function () {


                var successContent = '<div class="alert alert-success"><span>Update Completed Successfully</span></div>';
                $('#successMessage').html(successContent);

            });


        }

        $("#updateProfile").submit(function (event) {
            event.preventDefault();
            saveProfile();
        });

        $("#updateInformation").submit(function (event) {
            event.preventDefault();
            saveInformation();
        });

        $("input").focus(function () {
            var parent = ($(this).parentsUntil(".profile").parent().attr('id'));
            var value = $(this).attr('value');

            $(this).blur(function () {
                var newValue = $(this).val();
                switch (parent) {
                    case 'changeInformation' :
                        if (value != newValue)
                            saveInformation();

                        break;

                    case 'changeProfile' :
                        if (value != newValue)
                            saveProfile();

                        break;
                }
            })
        });


        $(document).on('blur', '#about', function () {
            saveInformation();
        });


    </script>






@endsection