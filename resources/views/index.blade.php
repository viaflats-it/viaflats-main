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
                            <div id="successMessageSignin"></div>
                            <div class="col-md-4">
                                <div class="form-group" id="login_has_error">
                                    {!! Form::open(['id' => 'signin']) !!}
                                    {!! Form::label('login', 'Login') !!}
                                    {!! Form::text('login', null, ['class' => 'form-control ']) !!}
                                    <div id="login_error"></div>
                                    {!! Form::label('password', 'Password') !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    <div id="password_error"></div>
                                    {!! Form::submit('Signin', ['class' => 'btn btn-default']) !!}
                                    {!! Form::close() !!}


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

        $('#signup').click(function () {
            $('#signupModal').modal();
        });

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
                        var successContent = '<div class="alert alert-danger"><span>{{trans('auth.error')}}'+ value+'</span></div>';
                        $('#successMessageSignin').html(successContent);
                    });

                }
                if (data.success){
                    var success = "{{trans('auth.success')}}";
                    var successContent = '<div class="alert alert-success"><span>'+success+'</span></div>';
                    $('#successMessageSignin').html(successContent);

                    window.location.replace(data.url_return);

                }

            });


        });
    </script>
@endsection
