<?php session_start(); ?>
@extends('layout.app')

@section('contenu')


    <div class="container">

        <h3>HEADER</h3>
        <!-- Modal -->
        <div id="loginModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">
                                    {!! Form::open(['url' => 'login']) !!}
                                    {!! Form::label('login', 'Login') !!}
                                    {!! Form::text('login', null, ['class' => 'form-control ']) !!}
                                    {!! Form::label('password', 'Password') !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    {!! Form::submit('Signin', ['class' => 'btn btn-default']) !!}
                                    {!! Form::close() !!}


                                </div>
                            </div>


                            <div style="position:relative; valign:middle; transform:translateY(200%);" class="col-md-4">
                                @if(!isset($_SESSION['facebook_access_token']))
                                    @include('facebooklogin')
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <div id="signupModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Signup</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">


                            <div class="form-group">
                                {!! Form::open(['url' => 'signup']) !!}

                                <div class="form-group">

                                    <div id ='phone' class="col-md-6 form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>'Phone']) !!}
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                        {!! Form::text('login', null, ['class' => 'form-control','placeholder'=>'Login']) !!}
                                        @if ($errors->has('login'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('login') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        {!! Form::email('email', null, ['class' => 'form-control','placeholder'=>'Mail']) !!}
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('first-name') ? ' has-error' : '' }}">
                                        {!! Form::text('first-name', null, ['class' => 'form-control','placeholder'=>'First Name']) !!}
                                        @if ($errors->has('first-name'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('first-name') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('last-name') ? ' has-error' : '' }}">
                                        {!! Form::text('last-name', null, ['class' => 'form-control','placeholder'=>'Last Name']) !!}
                                        @if ($errors->has('last-name'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('last-name') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        {!! Form::password('password',['class' => 'form-control','placeholder'=>'Password']) !!}
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder'=>'Password Confirm']) !!}
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <br>

                                    <div class="row form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <div class="col-md-6" style = "padding-left: 40px">
                                            {!! Form::label('type',"I'm a landlord") !!}
                                            {!! Form::radio('type','1') !!}
                                        </div>
                                        <div class="col-md-6" style = "padding-left: 20px">
                                            {!! Form::label('type',"I'm a tenant") !!}
                                            {!! Form::radio('type','0') !!}
                                        </div>
                                        @if ($errors->has('type'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div id="terms" class="row"
                                         style="margin-left:40px;border: double;margin-right:40px;overflow:auto;height:200px;">
                                        {{trans('auth.terms')}}

                                    </div>
                                    <div style="margin-left: 40px;margin-right: 40px;text-align: center">
                                        <p>
                                            You have to read the terms and conditions before signup !
                                        </p>
                                        <p>
                                            If you sign up, it mean's you agree with them !
                                        </p>
                                    </div>

                                </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                @if(!isset($_SESSION['facebook_access_token']) && !isset($_SESSION['google_access_token']))
                                {!! Form::label(trans('auth.fblogin')) !!}
                                @include('facebooklogin')
                                {!! Form::label(trans('auth.googlelogin')) !!}
                                @include('googlelogin')
                                @endif

                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

            </div>
        </div>


        <div class="row">
            <div class="col-md-2 col-md-push-1">
                <p>
                    @if(Auth::check())
                    connexion :{{Auth::user()->account}}
                    {{Auth::user()}}

                        @endif
                </p>
            </div>
        </div>


    </div>

    <script>



        $('#terms').on('scroll',function () {
            var div = $(this);
            if (div[0].scrollHeight - div.scrollTop() == div.height())//scrollTop is 0 based
            {
                $('.submit').show();
            }else{
                $('.submit').hide();
            }
        });

        $('#signup').click(function () {
            $('#signupModal').modal();
        });

        @if($errors->any() && !Auth::check() )
            $('#signupModal').modal('show');
        @endif

        $('#login').click(function () {
            $('#loginModal').modal();
        });
    </script>


@endsection
