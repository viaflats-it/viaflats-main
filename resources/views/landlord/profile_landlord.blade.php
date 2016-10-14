@extends('layout.landlord')

@section('contenu')

    <div class="row profile">
        <div class="col-md-12">
            <h3>@lang('landlord.profile')</h3>
            <div class="row ">
                <form action="profile" method="post">
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group  {{ $errors->has('first_name')? 'has-error' :'' }} ">
                                <label for="first_name">@lang('landlord.first_name')</label>
                                <input type="text" name="first_name" id="first_name"
                                       class="form-control"
                                       value="{{Auth::user()->first_name ? Auth::user()->first_name: Input::old('first_name') }}"/>
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group  {{ $errors->has('last_name')? 'has-error' :'' }} ">
                                <label for="last_name">@lang('landlord.last_name')</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                       value="{{Auth::user()->last_name ? Auth::user()->last_name: Input::old('last_name') }}"/>
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group  {{ $errors->has('email')? 'has-error' :'' }} ">
                                <label for="email">@lang('landlord.email')</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{Auth::user()->email ? Auth::user()->email: Input::old('email') }}"/>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group  {{ $errors->has('phone')? 'has-error' :'' }}  {{ $errors->has('phone_indicator')? 'has-error' :'' }}  ">
                                <label for="phone">@lang('landlord.phone')</label>
                                <div style="display:flex;">
                                    <div class="input-group" style="width: 35%">
                                        <div class="input-group-addon">+</div>
                                        <input type="text" class="form-control" name="phone_indicator"
                                               id="phone_indicator"
                                               value="{{Auth::user()->phone_indicator ? Auth::user()->phone_indicator: Input::old('phone_indicator') }}">
                                    </div>
                                    <input type="number" name="phone" id="phone" class="form-control"
                                           style="width: 65%; float: right"
                                           value="{{Auth::user()->phone ? Auth::user()->phone: Input::old('phone') }}"/>
                                </div>
                                @if ($errors->has('phone') || $errors->has('phone_indicator'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_indicator') }}</strong>
                                        <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                                    @endif
                                    </br>
                                    <button type="submit" class="btn  btn-viaflats">@lang('landlord.update')</button>

                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group  {{ $errors->has('login')? 'has-error' :'' }} ">
                                <label for="login">@lang('landlord.login')</label>
                                <input type="text" name="login" id="login" class="form-control"
                                       value="{{Auth::user()->login ? Auth::user()->login: Input::old('login') }}"/>
                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                </span>
                                @endif
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

            <div class="row">
                <div class="col-md-3">

                    @foreach($errors as $error)
                        {{$error}}
                    @endforeach

                    <div class="form-group {{ $errors->has('actual_password')? 'has-error' :'' }}{{ $errors->has('ApassWrong')? 'has-error' :'' }} ">

                        {!! Form::open(['url'=>'updatePassword']) !!}
                        {!! Form::label('actual_password', trans('landlord.actual_password')) !!}
                        {!! Form::password('actual_password', ['class' => 'form-control']) !!}
                        @if ($errors->has('actual_password'))
                            <span class="help-block">
                                        <strong>{{$errors->first('actual_password')}}</strong>
                                </span>
                        @elseif($errors->has('ApassWrong'))
                            <span class="help-block">
                                        <strong>{{$errors->first('ApassWrong')}}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('new_password')? 'has-error' :'' }} {{ $errors->has('new_password_confirmation')? 'has-error' :'' }} ">

                        {!! Form::label('new_password', trans('landlord.new_password')) !!}
                        {!! Form::password('new_password', ['class' => 'form-control']) !!}
                        @if ($errors->has('new_password'))
                            <span class="help-block">
                                        <strong>{{$errors->first('new_password')}}</strong>
                                </span>
                        @endif
                        {!! Form::label('new_password_confirmation', trans('landlord.new_password_confirmation')) !!}
                        {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                        @if ($errors->has('new_password_confirmation'))
                            <span class="help-block">
                                        <strong>{{$errors->first('new_password_confirmation')}}</strong>
                                </span>
                        @endif
                    </div>
                    {!! Form::submit(trans('landlord.update'), ['class'=>'btn btn-viaflats']) !!}
                    {!! Form::close() !!}
                </div>
            </div>


        </div>
    </div>

    <div class="row profile" id="moreInformation">
        <div class="col-md-12">
            <h3>@lang('landlord.moreInformation')</h3>
            <div class="row">
                <div class="col-md-3">
                    {!! Form::open(['url' => 'updateInformation']) !!}
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

                    <div class="form-group">
                    </div>
                </div>
            </div>
            {!! Form::submit(trans('landlord.update'), ['class' => 'btn btn-viaflats']) !!}
            {!! Form::close() !!}

        </div>
    </div>



@endsection