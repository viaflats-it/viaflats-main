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
                        <h4 class="modal-title"> {{trans('auth.login')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="successMessageSignin"></div>
                            <div class="col-md-4">
                                <div class="form-group" id="login_has_error">
                                    {!! Form::open(['id' => 'signin']) !!}
                                    {!! Form::label('login', trans('auth.username')) !!}
                                    {!! Form::text('login', null, ['class' => 'form-control ']) !!}
                                    <div id="login_error"></div>
                                    {!! Form::label('password', trans('auth.password') )!!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    <div id="password_error"></div>
                                    {!! Form::submit(trans('auth.signin'), ['class' => 'btn btn-default']) !!}
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('auth.close')}}</button>
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
                        <h4 class="modal-title"> {{trans('auth.signup')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">


                            <div class="form-group">
                                {!! Form::open(['url' => 'signup']) !!}

                                <div class="form-group">

                                    <div class="col-md-12 form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                        {!! Form::text('login', null, ['class' => 'form-control','placeholder' => trans('auth.username') ]) !!}
                                        @if ($errors->has('login'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('login') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {!! Form::text('phone', null, ['class' => 'form-control','id'=>'phone']) !!}
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        {!! Form::email('email', null, ['class' => 'form-control','placeholder'=> trans('auth.email')]) !!}
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('first-name') ? ' has-error' : '' }}">
                                        {!! Form::text('first-name', null, ['class' => 'form-control','placeholder'=>trans('auth.first_name')]) !!}
                                        @if ($errors->has('first-name'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('first-name') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('last-name') ? ' has-error' : '' }}">
                                        {!! Form::text('last-name', null, ['class' => 'form-control','placeholder'=>trans('auth.last_name')]) !!}
                                        @if ($errors->has('last-name'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('last-name') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        {!! Form::password('password',['class' => 'form-control','placeholder'=>trans('auth.password')]) !!}
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder'=> trans('auth.confirm_password')]) !!}
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <br>

                                    <div class="row form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <div class="col-md-6" style="padding-left: 40px">
                                            {!! Form::label('type',trans('auth.landlord')) !!}
                                            {!! Form::radio('type','1') !!}
                                        </div>
                                        <div class="col-md-6" style="padding-left: 20px">
                                            {!! Form::label('type',trans('auth.tenant')) !!}
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
                                            {{trans('auth.accept_terms')}}
                                        </p>
                                        <p>
                                            {{trans('auth.accept_terms_')}}
                                        </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-8 ">
                            <div class="form-group ">
                                @if(!isset($_SESSION['facebook_access_token']) && !isset($_SESSION['google_access_token']))
                                    @include('facebooklogin')
                                    @include('googlelogin')
                                @endif
                            </div>
                        </div>
                        {!! Form::submit(trans('auth.signup_button'), ['class' => 'btn btn-default  signup ','style'=>'display:none',]) !!}
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('auth.close')}}</button>
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
        $("#phone").intlTelInput();
    </script>
    <script>


        $('#terms').on('scroll', function () {
            var div = $(this);
            $('.signup').hide();
            if (div[0].scrollHeight - div.scrollTop() == div.height())//scrollTop is 0 based
            {
                $('.signup').show();
            } else {
                $('.signup').hide();
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


        /* LOGING */
        $("#signin").submit(function (event) {
            event.preventDefault();
            var successContent = '<div class="alert alert-info"><span>Checking for Authentification</span></div>';
            $('#successMessageSignin').html(successContent);
            var $form = $(this),
                    url = "login";
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
                        var successContent = '<div class="alert alert-danger"><span>{{trans('auth.error')}}' + value + '</span></div>';
                        $('#successMessageSignin').html(successContent);
                    });
                }
                if (data.success) {
                    var success = "{{trans('auth.success')}}";
                    var successContent = '<div class="alert alert-success"><span>' + success + '</span></div>';
                    $('#successMessageSignin').html(successContent);
                    window.location.replace(data.url_return);
                }
            });
        });
    </script>


@endsection
