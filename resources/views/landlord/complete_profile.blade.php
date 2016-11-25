@extends('layout.landlord')

@section('content')

    <div class="row profile">
        <div class="col-md-12">
            <h3>@lang('landlord.profile')</h3>
            <div class="row ">
                    <div class="col-md-6">
                       {!! Form::open(['url' => 'complete_profile']) !!}

                        <div class="form-group {{$errors->has('login') ? 'has-error' : ''}}">
                            {!! Form::label('login' , trans('landlord.login')) !!}
                            {!! Form::text('login', null, ['class' => 'form-control']) !!}
                            @if($errors->has('login'))
                                <span class="help-block">
                                        <strong>{{$errors->first('login')}}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{$errors->has('password') ? 'has-error' : ''}} {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
                            {!! Form::label('password' , trans('landlord.password')) !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                            @if($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{$errors->first('password')}}</strong>
                                </span>
                            @endif
                            {!! Form::label('password_confirmation' , trans('landlord.password_confirmation')) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            @if($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{$errors->first('password_confirmation')}}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{$errors->has('terms') ? 'has-error' : ' '}}">
                            {!! Form::checkbox('terms') !!}
                            @if($errors->has('terms'))
                                <span class="help-block">
                                        <strong>{{$errors->first('terms')}}</strong>
                                </span>
                            @endif
                            <span>@lang('landlord.read_accept') <a href="general/terms_condition">@lang('landlord.terms_condition')</a></span>
                        </div>

                        {!! Form::submit(trans('landlord.send'), ['class'=>'btn btn-viaflats']) !!}
                        {!! Form::close() !!}


                    </div>

                </div>
        </div>


    </div>



@endsection