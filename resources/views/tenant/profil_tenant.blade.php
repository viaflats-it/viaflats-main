@extends('layout.tenant')

@section('contenu')

<section class="section section-about-place" id="aboutPlace">
  <h3 class="title">@lang('tenant.about_next_place')</h3>
  <div class="container">
    {!! Form::open(['url'=>'updatePlace','id'=>'updatePlace', 'class' => 'form'])!!}
    {!! Form::hidden('First_step',false) !!}
    <div class="form-container">
      <span class="sucess-message" id="successMessagePlace"></span>

      <div class="form-group" id="expected_city_has_error">
        {!! Form::label('expected_city',trans('tenant.expected_city')) !!}
        <div class="dropwdown">
          <input type="text" name="expected_city">
          <div class="input-hover" id="city_label">
            @foreach($list_city as $key=>$city)
              @if ($key == 1)
              {{ $city }}
              @endif
            @endforeach
          </div>
          <i class="fa fa-caret-down" aria-hidden="true"></i>
          <ul class="dropwdown-ul">
            @foreach($list_city as $key=>$city)
              <li class="dropwdown-li city-li" value="{{$key}}">
                {{ $city }}
              </li>
              @endforeach
          </ul>
        </div>

        <span class="error-message" id="expected_city_error"></span>
      </div>

      <div class="form-group" id="budget">
        {!! Form::label('amount',trans('tenant.budget_range')) !!}
        <span class="text center" id="amount">
            {{$tenant->budget_min}} € - {{$tenant->budget_max}} €
        </span>
        {!! Form::hidden('budget_min',$tenant->budget_min,['id'=>'budget_min','type'=>'hidden']) !!}
        {!! Form::hidden('budget_max',$tenant->budget_max,['id'=>'budget_max','type'=>'hidden']) !!}
        <div id="slider_range"></div>
      </div>

      <div class="form-group">
          {!! Form::label('expected_type','What type of room do you want ? ') !!}
          <div class="dropwdown">
            <input type="text" name="expected_city">
            <div class="input-hover" id="type_label">
              @foreach(trans('tenant.type_room') as $key=>$type_room)
                @if ($key == 0)
                {{ $type_room }}
                @endif
              @endforeach
            </div>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
            <ul class="dropwdown-ul">
              @foreach(trans('tenant.type_room') as $key=>$type_room)
                <li class="dropwdown-li type-li" value="{{$key}}">
                  {{ $type_room }}
                </li>
                @endforeach
            </ul>
          </div>
      </div>
      {!! Form::label('couple', trans('tenant.couple')) !!}
      <div class="form-group inline" id="couple_has_error">
        <div class="radio-container">
         {!! Form::radio('couple', 0, true, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label('couple', trans('tenant.no')) !!}
        <div class="radio-container">
         {!! Form::radio('couple', 0, true, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label('couple',trans('tenant.yes')) !!}
        <span class="error-message" id="couple_error"></span>
      </div>

      <div class="form-group" id="expected_in_has_error">
        {!! Form::label('expected_in',trans('tenant.expected_in')) !!}
        {!! Form::text('expected_in',$tenant->expected_in,array('class'=>'datepicker')) !!}
        <span class="error-message" id="expected_in_error"></span>
      </div>

      <div class="form-group" id="expected_out_has_error">
        {!! Form::label('expected_out',trans('tenant.expected_out')) !!}
        {!! Form::text('expected_out',$tenant->expected_out,['class'=>'datepicker']) !!}
        <span class="error-message" id="expected_out_error"></span>
      </div>
      {!! Form::submit(trans('tenant.save'),['class'=>"btn  btn-viaflats"]) !!}
    </div>
    {!! Form::close() !!}
  </div>
</section>

<section class="section section-about-you" id="aboutYou">
  <h3 class="title">@lang('tenant.about_you')</h3>
  <div class="container">
    {!! Form::open(['url'=>'updateAbout','id'=>'updateAbout', 'class' => 'form']) !!}
    {!! Form::hidden('First_step',false) !!}
    <div class="form-container">
      <span id="successMessageAbout"></span>
      <div class="form-group inline">
        @if($tenant->gender == 'Girl')
        {!! Form::label('gender', trans('tenant.girl')) !!}
        <div class="radio-container">
         {!! Form::radio('gender', 'Girl', true, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label('gender', trans('tenant.boy')) !!}
        <div class="radio-container">
         {!! Form::radio('gender', 'Boy', false, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        @else
        {!! Form::label('gender', trans('tenant.girl')) !!}
        <div class="radio-container">
         {!! Form::radio('gender', 'Girl', false, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        {!! Form::label('gender', trans('tenant.boy')) !!}
        <div class="radio-container">
         {!! Form::radio('gender', 'Boy', true, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
        @endif
      </div>

      <div class="form-group" id="first_name_has_error">
        {!! Form::label('first_name', trans('tenant.first_name')) !!}
        {!! Form::text('first_name',$user->first_name) !!}
        <span id="first_name_error"></span>
      </div>

      <div class="form-group" id="last_name_has_error">
        {!! Form::label('last_name',trans('tenant.last_name')) !!}
        {!! Form::text('last_name',$user->last_name) !!}
        <span id="last_name_error"></span>
      </div>

      <div class="form-group">
        {!! Form::label('nationality',trans('tenant.nationality')) !!}
        {!! Form::text('nationality',$tenant->nationality) !!}
      </div>

      <div class="form-group">
        {!! Form::label('about',trans('tenant.describe')) !!}
        {!! Form::textarea('about',$tenant->about) !!}
      </div>

      @if($tenant->student == 1)
      <div class="form-group inline" id="student">
        {!! Form::label('student', trans('tenant.student')) !!}
        <div class="radio-container">
         {!! Form::radio('student', '1', true, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
      </div>

      <div class="form-group inline" id="worker">
        {!! Form::label('student',trans('tenant.worker')) !!}
        <div class="radio-container">
         {!! Form::radio('student', '0', false, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
      </div>
      @else
      <div class="form-group inline" id="student">
        {!! Form::label('student', trans('tenant.student')) !!}
        <div class="radio-container">
         {!! Form::radio('student', '1', false, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
      </div>

      <div class="form-group inline" id="student">
        {!! Form::label('student',trans('tenant.worker')) !!}
        <div class="radio-container">
         {!! Form::radio('student', '0', true, ['class' => 'radio']) !!}
          <span class="radio-style"></span>
        </div>
      </div>
      @endif

      <div class="form-group" id="respons_student">
        {!! Form::label("work_studies", trans('tenant.studies')) !!}
        {!! Form::text("work_studies", $tenant->work_studies) !!}
        {!! Form::label("school_company", trans('tenant.school')) !!}
        {!! Form::text("school_company", $tenant->school_company) !!}
      </div>

      <div class="form-group">
        {!! Form::label('spoken_languages', trans('tenant.languages')) !!}
        {!! Form::text('spoken_languages', $tenant->spoken_languages) !!}
      </div>

      <div class="form-group">
        {!! Form::label('contact_pref',trans('tenant.contact')) !!}
        {!! Form::select('contact_pref',trans('tenant.contact_pref'),['value' => $tenant->contact_preference ]) !!}
      </div>

      <div class="form-group">
        {!! Form::label('tag') !!}
        {!! Form::text('tag',null,['id'=>'Tag_Input']) !!}
      </div>
      <a class="btn btn-viaflats" id="TagButton">Validate</a>

      <div class="from-group" id="Tag" >
          @foreach($list_tag as $t)
              <div class="col-md-4">
                  <span>{{$t->label}}</span>
                  <a class="TagDelete" id=tag{{$t->idTag}}>X</a>
              </div>
          @endforeach
      </div>
      {!! Form::submit(trans('tenant.save'),['class'=>"btn  btn-viaflats"])!!}
    </div>
    {!! Form::close() !!}

    <div class="form">
      <div class="form-container">
        <div class="form-group">
          @if($tenant->profile_picture != NULL)
            <img class="profilPic" src="images/profiles/{{$tenant->profile_picture}}">
          @else
            <img class="profilPic" src="images/profiles/profilePic.svg">
          @endif
        </div>
          <input type="submit" class="btn btn-viaflats" id="ProfilPictureButton" value="Upload My Picture"/>
      </div>
    </div>
  </div>
</section>

<section class="section section-trust-center" id="trustCenter">
  <h3 class="title">@lang('tenant.trust_center')</h3>
  <div class="container">
    {!! Form::open(['url'=>'updateTrustCenter','id'=>'updateTrustCenter', 'class' => 'form'])  !!}
    <h4 class="subtitle">More Info About You</h4>
    <div class="form-container">
      <span id="successMessageTrustCenter"></span>

      <div class="form-group" id="email_has_error">
        {!! Form::label('email',trans('tenant.email')) !!}
        {!! Form::email('email',$user->email) !!}
        <span class="error-message" id="email_error"></span>
      </div>

      <div class="form-group" id="phone_has_error">
        {!! Form::label('phone', trans('tenant.phone')) !!}
        {!! Form::text('phone', $user->phone) !!}
        <span class="error-message" id="phone_error"></span>
      </div>

      <div class="form-group" id="phone_has_error">
        {!! Form::label('Your Address') !!}
        {!! Form::label('street_number', trans('tenant.street_number')) !!}
        {!! Form::text('street_number',$address_T->street_number) !!}
        {!! Form::label('street_name',trans('tenant.street')) !!}
        {!! Form::text('street_name',$address_T->street) !!}
        {!! Form::label('complement',trans('tenant.complement')) !!}
        {!! Form::text('complement',$address_T->complement) !!}
        {!! Form::label('zip',trans('tenant.zip')) !!}
        {!! Form::text('zip',$address_T->zip) !!}
        {!! Form::label('city',trans('tenant.city')) !!}
        {!! Form::text('city',$address_T->city) !!}
        {!! Form::label('country',trans('tenant.country')) !!}
        {!! Form::text('country',$address_T->country) !!}
      </div>

      <h4 class="subtitle">About your parents</h4>

      <div class="form-group">
        {!! Form::label(trans('tenant.first_name')) !!}
        {!! Form::text('p_first_name',$parent->first_name) !!}
        {!! Form::label(trans('tenant.last_name')) !!}
        {!! Form::text('p_last_name',$parent->last_name) !!}
      </div>

      <div class="form-group">
        {!! Form::label(trans('tenant.phone')) !!}
        {!! Form::text('p_phone',$parent->phone) !!}
      </div>

      <div class="form-group">
        {!! Form::label(trans('tenant.email')) !!}
        {!! Form::text('p_email',$parent->email) !!}
      </div>

      {!! Form::label('parent_address',trans('tenant.address')) !!}
      @if(($parent->idAddress == NULL) || ($parent->idAddress == $tenant->idAddress))
      <div class="form-group">
        {!! Form::label(trans('tenant.yes')) !!}
        <div class="radio-container" id="Yes">
        {!! Form::radio('parent_address', 0, true, ['class' => 'radio'])!!}
          <span class="radio-style"></span>
        </div>

        {!! Form::label(trans('tenant.no')) !!}
        <div class="radio-container" id="No">
        {!! Form::radio('parent_address', 1, false, ['class' => 'radio'])!!}
          <span class="radio-style"></span>
        </div>
      </div>

      <div class="form-group" id="ParentAddressShow" style="display: none">
        {!! Form::label('p_street_number',trans('tenant.street_number')) !!}
        {!! Form::text('p_street_number') !!}
        {!! Form::label('p_street_name',trans('tenant.street')) !!}
        {!! Form::text('p_street_name') !!}
        {!! Form::label('p_complement',trans('tenant.complement')) !!}
        {!! Form::text('p_complement') !!}
        {!! Form::label('p_zip',trans('tenant.zip')) !!}
        {!! Form::text('p_zip') !!}
        {!! Form::label('p_city',trans('tenant.city')) !!}
        {!! Form::text('p_city') !!}
        {!! Form::label('p_country',trans('tenant.country')) !!}
        {!! Form::text('p_country') !!}
      </div>
      @else
      <div class="form-group">
        {!! Form::label(trans('tenant.yes')) !!}
        <div class="radio-container" id="Yes">
        {!! Form::radio('parent_address', 0, false, ['class' => 'radio'])!!}
          <span class="radio-style"></span>
        </div>

        {!! Form::label(trans('tenant.no')) !!}
        <div class="radio-container" id="No">
        {!! Form::radio('parent_address', 1, true, ['class' => 'radio'])!!}
          <span class="radio-style"></span>
        </div>
      </div>

      <div class="form-group" id="ParentAddressShow">
        {!! Form::label('p_street_number',trans('tenant.street_number')) !!}
        {!! Form::text('p_street_number') !!}
        {!! Form::label('p_street_name',trans('tenant.street')) !!}
        {!! Form::text('p_street_name') !!}
        {!! Form::label('p_complement',trans('tenant.complement')) !!}
        {!! Form::text('p_complement') !!}
        {!! Form::label('p_zip',trans('tenant.zip')) !!}
        {!! Form::text('p_zip') !!}
        {!! Form::label('p_city',trans('tenant.city')) !!}
        {!! Form::text('p_city') !!}
        {!! Form::label('p_country',trans('tenant.country')) !!}
        {!! Form::text('p_country') !!}
      </div>
      @endif
      {!! Form::submit(trans('tenant.save'),['class'=>"btn  btn-viaflats"]) !!}
    </div>
    {!! Form::close() !!}
    </div>
</section>

<section class="section section-file-center" id="updateFileCenter">
  <div class="container">
    {!! Form::open(['url' => 'updateIdentity','files' => true, 'class' => 'form']) !!}
    <div class="form-container">
        {!! Form::label('picture',trans('tenant.identity')) !!}
      <div class="form-group" id="picture_has_error">
        @if($tenant->identity != NULL)
          {!! Form::label(trans('tenant.file_load')) !!}
        @else
          {!! Form::label(trans('tenant.file_not_load')) !!}
        @endif
        {!! Form::file('picture') !!}
        <span id="picture_error"></span>
      </div>
      {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
    </div>
    {!! Form::close() !!}

    @if($tenant->student == 1)

      {!! Form::open(['url' => 'updateStudyAgreement','files' => true, 'class' => 'form', 'id' => 'Study_agreement']) !!}
      <div class="form-container">
        {!! Form::label('picture',trans('tenant.study_agreement')) !!}
        <div class="form-group" id="picture_has_error">
          {!! Form::label(trans('tenant.study_agreement_explanation')) !!}
          @if($tenant->study_agreement != NULL)
              {!! Form::label(trans('tenant.file_load')) !!}
          @else
              {!! Form::label(trans('tenant.file_not_load')) !!}
          @endif
          {!! Form::file('picture') !!}
          <span id="picture_error"></span>
        </div>
        {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
      </div>
      {!! Form::close() !!}

      {!! Form::open(['url' => 'updateWorkAgreement','files' => true, 'class' => 'form', 'id' => 'Work_agreement']) !!}
      <div class="form-container">
        {!! Form::label('picture',trans('tenant.work_agreement')) !!}
        <div class="form-group" id="picture_has_error">
          @if($tenant->work_agreement != NULL)
              {!! Form::label(trans('tenant.file_load')) !!}
          @else
              {!! Form::label(trans('tenant.file_not_load')) !!}
          @endif
          {!! Form::file('picture') !!}
          <span id="picture_error"></span>
        </div>
        {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
      </div>
      {!! Form::close() !!}
    </div>

    @else

    {!! Form::open(['url' => 'updateWorkAgreement','files' => true, 'class' => 'form', 'id' => 'Work_agreement']) !!}
    <div class="form-container">
      {!! Form::label('picture',trans('tenant.work_agreement')) !!}
      <div class="form-group" id="picture_has_error">
        @if($tenant->work_agreement != NULL)
            {!! Form::label(trans('tenant.file_load')) !!}
        @else
            {!! Form::label(trans('tenant.file_not_load')) !!}
        @endif
        {!! Form::file('picture') !!}
        <span id="picture_error"></span>
      </div>
      {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url' => 'updatePaySlip','files' => true, 'class' => 'form', 'id' => 'Pay_Slip']) !!}
    <div class="form-container">
      {!! Form::label('picture',trans('tenant.pay_slip')) !!}
      <div class="form-group" id="picture_has_error">
        @if($tenant->pay_slip != NULL)
            {!! Form::label(trans('tenant.file_load')) !!}
        @else
            {!! Form::label(trans('tenant.file_not_load')) !!}
        @endif
        {!! Form::file('picture') !!}
        <span id="picture_error"></span>
      </div>
      {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
    </div>
    {!! Form::close() !!}

    @endif
  </div>
</section>

<script>
        // DROPDOWN CITY
        $('.city-li').click(function(){
          $('#city_label').text($(this).text());
        });
        // DROPDOWN TYPE
        $('.type-li').click(function(){
          $('#type_label').text($(this).text());
        });

        $('#ProfilPictureButton').click(function () {
            $('#ProfilPicture').modal();
        });

        $(function () {
            var list = [
                <?php foreach ($all_Tag as $tag) { ?>
                        '{{$tag->label}}',
                <?php } ?>];
            $('#Tag_Input').autocomplete({
                source: list,
                minLength: 1,
            })
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
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("removedfile", function () {
                    this.removeAllFiles();
                    $.ajax({
                        url: 'deletePicture',
                    });
                });
            },
        };

        $('#student').change(function () {
            var content = '<div id="respons_student">' +
                    '<div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::label("work_studies", trans('tenant.studies')) !!}' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::text("work_studies",$tenant->work_studies) !!}' +
                    '</div>' +
                    '</div>' +
                    '<div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::label("school_company",trans('tenant.school')) !!}' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::text("school_company",$tenant->school_company) !!}' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            $('#respons_student').html(content);
            $("#Study_agreement").show();
            $('#Work_agreement').hide();
            $('#Pay_Slip').hide();
        });

        $("#worker").change(function () {
            var content = '<div id="respons_student" >' +
                    '<div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::label("work_studies",trans('tenant.work')) !!}' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::text("work_studies",$tenant->work_studies) !!}' +
                    '</div>' +
                    '</div>' +
                    '<div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::label("school_company",trans('tenant.company')) !!}' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '{!! Form::text("school_company",$tenant->school_company) !!}' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            $('#respons_student').html(content);
            $("#Study_agreement").hide();
            $('#Work_agreement').show();
            $('#Pay_Slip').show();
        });

        $("#No").on('change', function () {
            $('#ParentAddressShow').show();
        });

        $('#Yes').change(function () {
            $('#ParentAddressShow').hide();
        });

        function saveAbout(successContent) {
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
                    $.each(data.errors, function (index, value) {
                        var errorMsg = '#' + index + '_error';
                        var errorDiv = '#' + index + '_has_error';
                        $(errorMsg).addClass('required');
                        $(errorMsg).empty().append(value);
                        $(errorDiv).addClass('error');
                        $(errorDiv).addClass('has-error');
                    });
                    $('#successMessageAbout').empty();
                } else {
                    $('div').each(function () {
                        if ($(this).hasClass('required')) {
                            $(this).empty();
                        }
                    });
                    $('#successMessageAbout').html(successContent);
                    $('#Tag').html('');
                    var content = data.list_tag;
                    $(content).each(function (index, value) {
                        $("#Tag").append('<div class="col-md-4">' +
                                '<span>' + value.label + '</span>' +
                                '<a class="TagDelete" id=tag' + value.idTag + '>X</a>' +
                                '</div>'
                        );
                    });
                }
            });
        }

        function saveTrustCenter(successContent) {
            var $form = $('#updateTrustCenter'),
                    url = "updateTrustCenter";
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
                        $(errorMsg).addClass('required_has_error');
                        $(errorMsg).empty().append(value);
                        $(errorDiv).addClass('error');
                        $(errorDiv).addClass('has-error');
                    });
                    $('#successMessageTrustCenter').empty();
                } else {
                    $('div').each(function () {
                        if ($(this).hasClass('required_has_error')) {
                            $(this).empty();
                        }
                    });
                    $('#successMessageTrustCenter').html(successContent);
                }
            });
        }

        function savePlace(successContent) {
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
                    $('#successMessagePlace').empty();
                } else {
                    $('div').each(function () {
                        if ($(this).hasClass('required_error')) {
                            $(this).empty();
                        }
                    });
                    $('#successMessagePlace').html(successContent);
                }
            });
        }


        $("#updateAbout").submit(function (event) {
            event.preventDefault();
            var successContent = '<div class="alert alert-success"><span>Update Completed Successfully</span></div>';
            saveAbout(successContent);
        });

        $("#updatePlace").submit(function (event) {
            event.preventDefault();
            var successContent = '<div class="alert alert-success"><span>Update Completed Successfully</span></div>';
            savePlace(successContent);
        });

        $("#updateTrustCenter").submit(function (event) {
            event.preventDefault();
            var successContent = '<div class="alert alert-success"><span>Update Completed Successfully</span></div>';
            saveTrustCenter(successContent);
        });


        //Budget Range
        $(function () {
            @if($tenant->budget_min != NULL && $tenant->budget_max!=NULL)
            $("#slider_range").slider({
                range: true,
                min: 100,
                max: 3000,
                step: 50,
                values: [{{$tenant->budget_min}},{{$tenant->budget_max}}],
                slide: function (event, ui) {
                    $("#amount").html(ui.values[0] + "€ - " + ui.values[1] + "€");
                    $("#budget_min").val(ui.values[0]);
                    $("#budget_max").val(ui.values[1]);
                }
            });
            @else
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
            @endif
        });

        //Date Picker
        $(function () {
            $(".datepicker").datepicker();
        });

        //Autosave
        $("#aboutPlace").on('change', function () {
            savePlace("");
        });


        $("#Tag").on('click', ".TagDelete[id^='tag']", function (event) {
            event.preventDefault();
            var id = $(this).attr('id').replace('tag', '');
            var url = 'DeleteTagTenant';
            var posting = $.ajax({
                type: "POST",
                datType: "json",
                url: url,
                data: {
                    'data': id,
                    "_token": "{{ csrf_token() }}",
                }
            });
            posting.done(function (data) {
                $("#Tag").html("");
                $(data.list_tag).each(function (index, value) {
                    $("#Tag").append('<div class="col-md-4">' +
                            '<span>' + value.label + '</span>' +
                            '<a class="TagDelete" id=tag' + value.idTag + '>X</a>' +
                            '</div>'
                    );
                });
            });
        });


        //Autosave
        $("#TagButton").on('click', function () {
            saveAbout("");
        });

        //Autosave
        $('#trustCenter').on('change', function () {
            saveTrustCenter("");
        });

    </script>

@endsection
