@extends('layout.landlord')


@section('contenu')


    <div class="row profile">
        <div class="col-md-12">
            <h3>@lang('admin.addLandlord')</h3>

            <div class="col-md-4">
                {!! Form::open(['url' => 'addLandlord']) !!}
                <div class="form-group  {{ $errors->has('email')? 'has-error' :'' }} ">
                    {!! Form::label('email', trans('landlord.email')) !!}
                    {!! Form::email('email', Input::old('email'),['class' => 'form-control ']) !!}
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="form-group  {{ $errors->has('phone')? 'has-error' :'' }}  {{ $errors->has('phone_indicator')? 'has-error' :'' }}  ">
                    <label for="phone">@lang('landlord.phone')</label>
                    {!! Form::label('phone', trans('landlord.phone')) !!}
                    <div style="display:flex;">
                        <div class="input-group" style="width: 35%">
                            <div class="input-group-addon">+</div>
                            {!! Form::number('phone_indicator',Input::old('phone_indicator') , ['class' => 'form-control', 'style'=>'width:90%'])
                            !!}
                        </div>
                        {!! Form::number('phone', Input::old('phone'), ['class' => 'form-control', 'style'=>'width:60%; float:right'])
                        !!}
                    </div>
                    @if ($errors->has('phone') || $errors->has('phone_indicator'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('phone_indicator') }}</strong>
                                        <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif

                </div>
                <div class="form-group  {{ $errors->has('last_name')? 'has-error' :'' }} ">
                    {!! Form::label('last_name', trans('landlord.last_name')) !!}
                    {!! Form::text('last_name', Input::old('last_name'),['class' => 'form-control']) !!}
                    @if ($errors->has('last_name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="form-group  {{ $errors->has('first_name')? 'has-error' :'' }} ">
                    {!! Form::label('first_name', trans('landlord.first_name')) !!}
                    {!! Form::text('first_name', Input::old('first_name'),['class' => 'form-control']) !!}
                @if ($errors->has('first_name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                    @endif
                </div>
                {!! Form::submit(trans('landlord.send'), ['class'=>'btn btn-viaflats']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection