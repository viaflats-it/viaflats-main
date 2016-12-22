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
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('auth.close')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-------- SIGN UP --------->
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
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('auth.close')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!---------- TENANT FIRST STEP ------------>

        <!------ Modal First Step Tenant : ABOUT YOUR NEXT HOME ------>
        <div id="NextHomeStep" class="modal fade Home" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('tenant.about_next_place')</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url'=>'updatePlace','id'=>'updatePlace'])!!}
                        {!! Form::token() !!}
                        {!! Form::hidden('First_step',true) !!}
                        <div class="row" style="margin: 30px">
                            <!-------- City --------->
                            <div class="form-group row" id="expected_city_has_error">
                                <div class="col-md-6">
                                    {!! Form::label('expected_city',trans('tenant.expected_city')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::select('expected_city',trans('tenant.city_list'),['class'=>'checkSubmitPlace']) !!}
                                </div>
                                <div id="expected_city_error"></div>
                            </div>

                            <!----- Expected Room --->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    {!! Form::label('expected_type','What type of room do you want ? ') !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::select('expected_type',trans('tenant.type_room'),['class'=>'checkSubmitPlace']) !!}
                                </div>
                            </div>
                            <!----- Couple ------>
                            <div class="form-group row " id="couple_has_error">
                                <div class="col-md-12">
                                    {!! Form::label('couple',trans('tenant.couple')) !!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!! Form::label('couple',trans('tenant.no')) !!}
                                    {!! Form::radio('couple',0,true) !!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!! Form::label('couple',trans('tenant.yes')) !!}
                                    {!! Form::radio('couple',1) !!}
                                </div>
                                <div id="couple_error"></div>
                            </div>
                            <!--------Budget -------->
                            <div class="form-group row" id="budget">
                                <div class="col-md-6">
                                    {!! Form::label('amount',trans('tenant.budget_range')) !!}
                                </div>
                                <div id="amount" class="col-md-6"> 100 € - 3000 €</div>
                                <div>
                                    {!! Form::hidden('budget_min',100,['id'=>'budget_min','type'=>'hidden']) !!}
                                    {!! Form::hidden('budget_max',3000,['id'=>'budget_max','type'=>'hidden']) !!}
                                </div>
                                <br>
                                <div id="slider_range" class="col-md-8" style="margin-left:100px"></div>
                            </div>
                            <br>
                            <!----- Expected Date --->
                            <div class="form-group row">
                                <div id="expected_in_has_error">
                                    <div class="col-md-6">
                                        {!! Form::label('expected_in',trans('tenant.expected_in')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text('expected_in',null,array('class'=>'datepicker checkSubmitPlace')) !!}
                                    </div>
                                    <div id="expected_in_error"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div id="expected_out_has_error">
                                    <div class="col-md-6">
                                        {!! Form::label('expected_out',trans('tenant.expected_out')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text('expected_out',null,['class'=>'datepicker checkSubmitPlace']) !!}
                                    </div>
                                    <div id="expected_out_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit(trans('tenant.next'),['class'=>"btn  btn-viaflats submitForm",'disabled'=>true]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <!-------- Modal Second Step Tenant : ABOUT YOU ------->
        <div id="ProfilStep" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('tenant.about_you')</h4>
                    </div>
                    <div class="modal-body">
                    {!! Form::open(['url'=>'updateAbout','id'=>'updateAbout']) !!}
                    {!! Form::hidden('First_step',true) !!}
                    <!------------ Gender ----------->
                        <div class="form-group row " id="gender_has_error">
                            <div class="col-md-6">
                                {!! Form::label('gender',trans('tenant.girl')) !!}
                                {!! Form::radio('gender','Girl',true) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('gender',trans('tenant.boy')) !!}
                                {!! Form::radio('gender','Boy') !!}
                            </div>
                            <div id="gender_error"></div>
                        </div>
                        <!------------ Nationality ---------->
                        <div class="form-group row" id="nationality_has_error">
                            <div class="col-md-6">
                                {!! Form::label('nationality',trans('tenant.nationality')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('nationality',null,['class'=>'checkSubmitProfile']) !!}
                            </div>
                            <div id="nationality_error"></div>
                        </div>
                        <!------------ About --------->
                        <div class="form-group row" id="about_has_error">
                            <div class="col-md-6">
                                {!! Form::label('about',trans('tenant.describe')) !!}
                            </div>
                            <br>
                            <div class="col-md-6">
                                {!! Form::textarea('about',null,['size'=>'10x5','class'=>'checkSubmitProfile']) !!}
                            </div>
                            <div id="about_error"></div>
                        </div>
                        <!------------- Student / Worker ------------->
                        <div class="form-group row" id="student_has_error">
                            <div class="col-md-6" id="student">
                                {!! Form::label('student',trans('tenant.student')) !!}
                                {!! Form::radio('student','1',true) !!}
                            </div>
                            <div class="col-md-6" id='worker'>
                                {!! Form::label('student',trans('tenant.worker')) !!}
                                {!! Form::radio('student','0') !!}
                            </div>
                            <div id="student_error"></div>
                        </div>
                        <div class="form-group row " id="StudentInfo">
                            <div id="work_studies_has_error">
                                <div class="col-md-6">
                                    {!! Form::label("work_studies",trans('tenant.studies'),['class'=>'student_label']) !!}
                                    {!! Form::label("work_studies",trans('tenant.work'),['style'=>'display:none','class'=>'worker_label']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::text("work_studies",null,['class'=>'checkSubmitProfile']) !!}
                                </div>
                                <div id="work_studies_error"></div>
                            </div>
                            <div id="school_company_has_error">
                                <div class="col-md-6">
                                    {!! Form::label("school_company",trans('tenant.school'),['class'=>'student_label']) !!}
                                    {!! Form::label("school_company",trans('tenant.company'),['style'=>'display:none','class'=>'worker_label']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::text("school_company",null,['class'=>'checkSubmitProfile']) !!}
                                </div>
                                <div id="school_company_error"></div>
                            </div>
                        </div>
                        <!------------- Languages -------->
                        <div class="form-group row " id="spoken_languages_has_error">
                            <div class="col-md-6">
                                {!! Form::label('spoken_languages',trans('tenant.languages')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('spoken_languages',null,['class'=>'checkSubmitProfile']) !!}
                            </div>
                            <div id="spoken_languages_error"></div>
                        </div>
                        <!------- Contact Preference --------->
                        <div class="form-group row" id="contact_pref_has_error">
                            <div class="col-md-6">
                                {!! Form::label('contact_pref',trans('tenant.contact')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::select('contact_pref',trans('tenant.contact_pref')) !!}
                            </div>
                            <div id="contact_pref_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit(trans('tenant.next'),['class'=>"btn  btn-viaflats submitProfile",'disabled'=>true]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <div id="ProfilPicture" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('tenant.picture')</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6" style="text-align: center;margin-left:25%">
                                {!! Form::open(['url'=>'uploadFiles','class'=>'dropzone','id'=>'MyDropzone','files'=>true]) !!}
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        {!! Form::close() !!}
                        <button class="btn" id="passStep">@lang('tenant.pass_step')</button>
                        <button class="btn btn-viaflats" style="display:none;" id="continue">@lang('tenant.end')</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="LastStep" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">What about these property ? </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="property">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-viaflats" data-dismiss="modal">@lang('auth.close')</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Content -->
        <button type="button" id="test" class="btn btn-viaflats"> Test</button>
        <a href="SendConfirmationMail">
            <button type="button" id="SendMail" class="btn-viaflats btn"> Send Confirmation Mail</button>
        </a>

        <div class="row">
            <div class="col-md-2 col-md-push-1">
                <p>
                    @if(Auth::check())
                        connexion :{{Auth::user()->status}}
                        {{Auth::user()}}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <script>

        $("#phone").intlTelInput();
        
        $('#updatePlace').on('change', function () {
            if (checkFieldPlace()) {
                $('.submitForm').attr('disabled', false);
            }
        });

        $('#updateAbout').on('change',function(){
            if (checkFieldProfile()) {
                $('.submitProfile').attr('disabled', false);
            }
        });

        function checkFieldPlace() {
            var isValid = true;
            $('.checkSubmitPlace').each(function () {
                if ($(this).val() === '')
                    isValid = false;
            });
            return isValid;
        }

        function checkFieldProfile() {
            var isValid = true;
            $('.checkSubmitProfile').each(function () {
                if ($(this).val() === '')
                    isValid = false;
            });
            return isValid;
        }

        //First Step Tenant
        $(function () {
            var tenant = '{{ $first_tenant }}';
            if (tenant == 1) {
                $.ajax({
                    url: 'FirstStepTenant',
                });
                $('#NextHomeStep').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });

        //Budget Range
        $(function () {
            $("#slider_range").slider({
                range: true,
                min: 100,
                max: 3000,
                step: 50,
                values: [100, 3000],
                slide: function (event, ui) {
                    $("#amount").html(ui.values[0] + "€ - " + ui.values[1] + "€");
                    $("#budget_min").val(ui.values[0]);
                    $("#budget_max").val(ui.values[1]);
                }
            });
        });


        Dropzone.options.MyDropzone = {
            dictDefaultMessage: 'Drop your picture here !<br>Or<br> Click on it to select one !',
            paramName: "file",
            maxFiles: 1,
            addRemoveLinks: true,
            thumbnailWidth: "300",
            thumbnailHeight: "300",
            accept: function (file, done) {
                done()
            },
            init: function () {
                this.on("addedfile", function () {
                    $('#passStep').hide();
                    $('#continue').show();
                });
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("removedfile", function () {
                    this.removeAllFiles();
                    $.ajax({
                        url: 'deletePicture',
                    });
                    $('#passStep').show();
                    $('#continue').hide();
                });
            },
        };


        //Date Picker
        $(function () {
            $(".datepicker").datepicker();
        });

        $('#test').click(function () {
            $("#NextHomeStep").modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        function savePlace() {
            var $form = $('#updatePlace'),
                    url = "updatePlace";
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
                        $(errorMsg).addClass('required_error');
                        $(errorMsg).empty().append(value);
                        $(errorDiv).addClass('error');
                        $(errorDiv).addClass('has-error');
                    });
                    $('#NextHomeStep').modal('show');
                } else {
                    $('div').each(function () {
                        if ($(this).hasClass('required_error')) {
                            $(this).empty();
                        }
                    });
                    $('#NextHomeStep').modal('hide');
                    $('#ProfilStep').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            });
        }

        $("#updatePlace").submit(function () {
            event.preventDefault();
            savePlace();
        });

        function saveAbout() {
            var $form = $('#updateAbout'),
                    url = "updateAbout";
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
                    $('div').each(function () {
                        if ($(this).hasClass('required')) {
                            $(this).empty();
                        }
                    });
                    $.each(data.errors, function (index, value) {
                        var errorMsg = '#' + index + '_error';
                        var errorDiv = '#' + index + '_has_error';
                        $(errorMsg).addClass('required');
                        $(errorMsg).empty().append(value);
                        $(errorDiv).addClass('error');
                        $(errorDiv).addClass('has-error');
                    });
                    $("#ProfilStep").modal('show');
                } else {
                    $('div').each(function () {
                        if ($(this).hasClass('required')) {
                            $(this).empty();
                        }
                    });
                    $("#ProfilStep").modal('hide');
                    $("#ProfilPicture").modal();
                }
            });
        }

        $("#student").on('change', function () {
            $('.student_label').show();
            $('.worker_label').hide();
        });

        $("#worker").on('change', function () {
            $('.student_label').hide();
            $('.worker_label').show();

        });

        $("#updateAbout").on('submit', function () {
            event.preventDefault();
            saveAbout();

        });

        $('#continue,#passStep').on('click', function () {
            $("#ProfilPicture").modal('hide');
            var posting = $.ajax({
                url:'FirstStepProperties'
            });
            posting.done(function(data){
                console.log(data);
                console.log(data.Property[0]);
                $("#LastStep").modal({
                    backdrop: 'static',
                    keyboard: false
                });
                var Property = $("#property");
                Property.html('');
                for(var i=0;i<5;i++){
                    if(data.Property[i] != undefined){
                        property.append('<div style="text-align: center;"><img src="property/'+ data.Property[i].picture +
                                '" width="100" height="..."/></div>' +
                                data.Property[i].title +'<br> Rent:' + data.Property[i].rent +
                                '<br> City '+ data.City +'<br> Area '+data.Area[i].label+'<br> Available from '+
                                data.Available[i]);
                    }else{
                        break;
                    }
                }
            });
        });


        /* SIGNIN */
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

        /* LOGING */
        $('#login').click(function () {
            $('#loginModal').modal();
        });

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
