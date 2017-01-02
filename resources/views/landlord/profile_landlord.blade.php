@extends('layout.landlord')

@section('content')

<section class="section section-profile" id="changeProfile">
  <h1 class="title">@lang('landlord.profile')</h1>
  <div class="container">
    <form class="form" id="updateProfile" action="profile" method="post">
      <div class="form-container">
        <span class="sucess-message" id="successMessageProfile"></span>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group" id="first_name_has_error">
            <label for="first_name">@lang('landlord.first_name')</label>
            <input type="text" name="first_name" id="first_name"
                   class="form-control"
                   value="{{Auth::user()->first_name ? Auth::user()->first_name: '' }}"/>
            <span class="error-message" id="first_name_error"></span>
        </div>

        <div class="form-group" id="last_name_has_error">
            <label for="last_name">@lang('landlord.last_name')</label>
            <input type="text" name="last_name" id="last_name" class="form-control"
                   value="{{Auth::user()->last_name ? Auth::user()->last_name: '' }}"/>
            <span class="error-message" id="last_name_error"></span>
        </div>

        <div class="form-group" id="email_has_error">
            <label for="email">@lang('landlord.email')</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{Auth::user()->email ? Auth::user()->email: '' }}"/>
            <span class="error-message" id="email_error"></span>
        </div>
        <div class="form-group" id="phone_has_error">
            <label for="phone">@lang('landlord.phone')</label>
            <input type="tel" class="form-control form-phone" id="phone"
                   value="{{Auth::user()->phone ? Auth::user()->phone: ''}}" />
            <span class="error-message" id="phone_error"></span>
            <span class="error-message" id="phone_indicator_error"></span>
        </div>
        <input type="submit" class="btn btn-submit" value="@lang('landlord.update')"/>
      </div>
    </form>
    {!! Form::open(['url' => 'landlord_picture', 'class' => 'form', 'files' => true ]) !!}
    <div class="form-container">
      <div class="form-group">
        <img class="profilPic" src="images/profiles/{{$landlord->profile_picture}}">
        {!! Form::file('image') !!}
      </div>
      {!! Form::submit(trans('landlord.send'), ['class'=>'btn btn-submit']) !!}
    </div>
      {!! Form::close() !!}
  </div>
</section>

<section class="section section-information" id="changeInformation">
  <h1 class="title">@lang('landlord.moreInformation')</h1>
  <div class="container">
    {!! Form::open(['id' => 'updateInformation', 'class' => 'form', 'url' => 'updateInformation']) !!}
    <div class="form-container">
      <div class="form-group">
        {!! Form::label('about' , trans('landlord.about')) !!}
        {!! Form::textarea('about', $landlord->about, ['class' => 'form-control', 'size' => '30x5']) !!}
      </div>
      @if ($errors->has('about'))
      <span class="help-block" class="error-message">                                   {{$errors->first('about')}}
      </span>
      @endif
      {!! Form::label('contact_preference' , trans('landlord.contact_preference')) !!}
      <div class="form-group inline">
         <div class="radio-container">
          {!! Form::radio('contact_preference', '2', $landlord->contact_preference == 2 ? 'true' : '', ['class' => 'radio']) !!}
           <span class="radio-style"></span>
         </div>
        {!! Form::label(trans('landlord.email')) !!}
        <div class="radio-container">
        {!! Form::radio('contact_preference', '1',  $landlord->contact_preference == 1 ? 'true' : '', ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label(trans('landlord.phone')) !!}
        <div class="radio-container">
        {!! Form::radio('contact_preference', '0',  $landlord->contact_preference == 0 ? 'true' : '', ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label(trans('landlord.none')) !!}
      </div>
      {!! Form::label('corporate' , trans('landlord.corporate')) !!}
      <div class="form-group inline">
        <div class="radio-container">
        {!! Form::radio('corporate', '0',  $landlord->corporate == 0 ? 'true' : '', ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label(trans('landlord.private')) !!}
        <div class="radio-container">
        {!! Form::radio('corporate', '1', $landlord->corporate == 1 ? 'true' : '', ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label(trans('landlord.corporate')) !!}
      </div>
        {!! Form::label(trans('landlord.paymentType')) !!}
    <!-- WE MAY FIND ANOTHER SOLUTION HERE -->
        <div class="form-group inline" id="payment">
            @foreach($payment as $p)
                @if ($p <= 3)
                    {!! Form::label($p) !!}
                    <div class="radio-container">
                        {!!Form::checkbox('payment_way[]',array_search($p,$payment),(in_array(array_search($p,$payment),$land_payment)) ? 'true' : '', ['class' => 'radio'])!!}
                        <span class="radio-style"></span>
                    </div>
                @endif
            @endforeach
        </div>
      <div class="form-group">
        {!! Form::label('company_web' ,trans('landlord.company_web')) !!}
        {!! Form::text('company_web', $landlord->company_website , ['class' => 'form-control']) !!}
      </div>
      {!! Form::submit(trans('landlord.update'), ['class' => 'btn btn-viaflats']) !!}
    </div>
    {!! Form::close() !!}
  </div>
</section>

<section class="section section-password" id="changePassword">
    <h1 class="title">@lang('landlord.changePassword')</h1>
    <div class="container">
        {!! Form::open(['id' => 'updatePassword', 'class' => 'form', 'url' => 'updatePassword']) !!}
        <div class="form-container">
            <span class="sucess-message" id="successMessagePassword"></span>
            <div class="form-group" id="actual_password_has_error">
                {!! Form::label('actual_password', trans('landlord.actual_password')) !!}
                {!! Form::password('actual_password', ['class' => 'form-control']) !!}
                <span class="error-message" id="actual_password_error"></span>
            </div>
            <div class="form-group" id="new_password_has_error">
                {!! Form::label('new_password', trans('landlord.new_password')) !!}
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
                <span <span class="error-message" id="new_password_error"></span>
                {!! Form::label('new_password_confirmation', trans('landlord.new_password_confirmation')) !!}
                {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                <span <span class="error-message" id="new_password_confirmation_error"></span>
            </div>
            {!! Form::submit(trans('landlord.update'), ['class'=>'btn btn-submit']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</section>

<script type="text/javascript">
  $("#phone").intlTelInput();

  $.ajax({
    url:'images/profiles/{{$landlord->profile_picture}}',
    error:
      function(){
          $('.profilPic').attr("src", 'images/profiles/profilePic.svg');
      }
    });

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
                    "phone": phone,
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
