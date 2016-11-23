@extends('layout.tenant')

@section('contenu')
    <div class="row profile">

        <div class="col-md-12">
            <h3>@lang('tenant.change_password')</h3>
            <div>
                <div id="successMessagePassword"></div>
                <div class="col-md-6">
                    <div class="form-group row " id="actual_password_has_error">
                        {!! Form::open(['url'=>'updatePasswordTenant','id'=>'updatePasswordTenant']) !!}
                        <div class="col-md-6">
                            {!! Form::label('actual_password',trans('tenant.actual_password')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::password('actual_password') !!}
                        </div>
                        <div id="actual_password_error"></div>
                    </div>
                    <div class="form-group row " id="new_password_has_error">
                        <div class="col-md-6">
                            {!! Form::label('new_password',trans('tenant.new_password')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::password('new_password') !!}
                        </div>
                        <div id="new_password_error"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('new_password_confirmation',trans('tenant.confirmation_new_password')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::password('new_password_confirmation') !!}
                        </div>
                        <div id="new_password_confirmation_error"></div>
                    </div>
                    {!! Form::submit(trans('tenant.change_password'),['class'=>"btn  btn-viaflats"]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="col-md-12">
            <h3>@lang('tenant.disable_account')</h3>
            <p>
                Text d'explication
            </p>
            <div>
                <button id="disable" class="btn  btn-viaflats">@lang('tenant.disable')</button>
            </div>
        </div>

        <div class="col-md-12">
            <h3>@lang('tenant.delete_account')</h3>
            <p>
                Text d'explication
            </p>
            <div>
                <button id = "delete" class="btn  btn-viaflats">@lang('tenant.delete')</button>
            </div>
        </div>

        <div id="disableModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Are you sure ? </h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            Text explication
                        </p>

                    </div>
                    <div class="modal-footer">
                        <a href="disable">
                            <button id="disableConfirmation" class="btn  btn-viaflats">Yes i'm sure !</button>
                        </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('auth.close')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="deleteModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Are you sure ? </h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            Text explication
                        </p>

                    </div>
                    <div class="modal-footer">
                        <a href="delete">
                            <button id="deleteConfirmation" class="btn  btn-viaflats">Yes i'm sure !</button>
                        </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('auth.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $('#disable').click(function(){
            $('#disableModal').modal();
        });

        $('#delete').click(function(){
            $('#deleteModal').modal();
        });

        $("#updatePasswordTenant").submit(function (event) {
            event.preventDefault();
            var $form = $('#updatePasswordTenant'),
                    url = "updatePasswordTenant";

            var posting = $.ajax({
                method: "POST",
                url: url,
                data: {
                    'data': $form.serialize(),
                    "_token": "{{ csrf_token() }}"
                }
            });
            posting.done(function (data) {
                console.log(data);
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

    </script>
@endsection