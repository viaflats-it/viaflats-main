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
    <div id="signupModal" class="modal fade" role="dialog">
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
                                {!! Form::open(['url' => 'signup']) !!}
                                {!! Form::label('login', 'Login') !!}
                                {!! Form::text('login', null, ['class' => 'form-control', 'placeholder'=>'username']) !!}
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                                {!! Form::submit('Signup', ['class' => 'btn btn-default']) !!}
                                {!! Form::close() !!}
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


</div>

<script>

    $('#signup').click(function () {
        $('#signupModal').modal();
    });

    $('#login').click(function () {
        $('#loginModal').modal();
    });
</script>
@endsection
