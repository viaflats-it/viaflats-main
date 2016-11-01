@extends('layout.tenant')

@section('contenu')

    <div class="row profile">
        <!----------About your next place Section ------------->
        <div class="col-md-12">
            <h3>@lang('tenant.about_next_place')</h3>
            <div id="aboutPlace">
                {!! Form::open(['url'=>'updatePlace','id'=>'updatePlace'])!!}
                {!! Form::token() !!}
                <div id="successMessagePlace"></div>
                <div class="col-md-6">
                    <!-------- City --------->
                    <div class="form-group row" id="expected_city_has_error">
                        <div class="col-md-6">
                            {!! Form::label('expected_city',trans('tenant.expected_city')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::select('expected_city',$array,['value'=>$tenant->expected_city]) !!}
                        </div>
                        <div id="expected_city_error"></div>
                    </div>
                    <!--------Budget -------->
                    <div class="form-group row" id="budget">
                        <div class="col-md-6">
                            {!! Form::label('amount',trans('tenant.budget_range')) !!}
                        </div>
                        <div id="amount">
                            {{$tenant->budget_min}} € - {{$tenant->budget_max}} €
                        </div>
                        <div>
                            {!! Form::hidden('budget_min',$tenant->budget_min,['id'=>'budget_min','type'=>'hidden']) !!}
                            {!! Form::hidden('budget_max',$tenant->budget_max,['id'=>'budget_max','type'=>'hidden']) !!}
                        </div>
                        <br>
                        <div id="slider_range"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!----- Expected Room --->
                    <div class="form-group">
                        {!! Form::label('expected_type','What type of room do you want ? ') !!}
                        {!! Form::select('expected_type',trans('tenant.type_room'),['value' => $tenant->expected_type]) !!}
                    </div>
                    <!----- Expected Date --->
                    <div class="form-group">
                        <div id="expected_in_has_error">
                            <div class="col-md-6">
                                {!! Form::label('expected_in',trans('tenant.expected_in')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('expected_in',$tenant->expected_in,array('class'=>'datepicker')) !!}
                            </div>
                            <div id="expected_in_error"></div>
                        </div>
                        <div id="expected_out_has_error">
                            <div class="col-md-6">
                                {!! Form::label('expected_out',trans('tenant.expected_out')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('expected_out',$tenant->expected_out,['class'=>'datepicker']) !!}
                            </div>
                            <div id="expected_out_error"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    {!! Form::submit(trans('tenant.save'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!--------------- About you Section --------------->
        <div class="col-md-12">
            <h3>@lang('tenant.about_you')</h3>
            <div id="aboutYou">
                {!! Form::open(['url'=>'updateAbout','id'=>'updateAbout']) !!}
                <div id="successMessageAbout"></div>
                <div class="col-md-6">
                    <!------------ Gender ----------->
                    <div class="form-group">
                        @if($tenant->gender == 'Girl')
                            <div class="form-group col-md-6">
                                {!! Form::label('gender',trans('tenant.girl')) !!}
                                {!! Form::radio('gender','Girl',true) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('gender',trans('tenant.boy')) !!}
                                {!! Form::radio('gender','Boy') !!}
                            </div>
                        @else
                            <div class="form-group col-md-6">
                                {!! Form::label('gender',trans('tenant.girl')) !!}
                                {!! Form::radio('gender','Girl') !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('gender',trans('tenant.boy')) !!}
                                {!! Form::radio('gender','Boy',true) !!}
                            </div>
                        @endif
                    </div>
                    <!---------- Name ------------>
                    <div class="form-group" id="first_name_has_error">
                        {!! Form::label('first_name', trans('tenant.first_name')) !!}
                        {!! Form::text('first_name',$user->first_name) !!}
                        <div id="first_name_error"></div>
                    </div>
                    <div class="form-group" id="last_name_has_error">
                        {!! Form::label('last_name',trans('tenant.last_name')) !!}
                        {!! Form::text('last_name',$user->last_name) !!}
                        <div id="last_name_error"></div>
                    </div>
                    <!------------ Nationality ---------->
                    <div class="form-group">
                        {!! Form::label('nationality',trans('tenant.nationality')) !!}
                        {!! Form::text('nationality',$tenant->nationality) !!}
                    </div>
                    <!------------ About --------->
                    <div class="form-group">
                        {!! Form::label('about',trans('tenant.describe')) !!}
                        {!! Form::textarea('about',$tenant->about) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <!------------- Student / Worker ------------->
                    <div class="form-group">
                        @if($tenant->student == 1)
                            <div class="row" id="student">
                                <div class="col-md-6">
                                    {!! Form::label('student',trans('tenant.student')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::radio('student','1',true) !!}
                                </div>
                            </div>
                            <div class="row" id='worker'>
                                <div class="col-md-6">
                                    {!! Form::label('student',trans('tenant.worker')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::radio('student','0') !!}
                                </div>
                            </div>
                            <br>
                            <div id="respons_student" class="form-group">
                                <div>
                                    <div class="col-md-6">
                                        {!! Form::label("work_studies",trans('tenant.studies')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text("work_studies",$tenant->work_studies) !!}
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-6">
                                        {!! Form::label("school_company",trans('tenant.school')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text("school_company",$tenant->school_company) !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row" id="student">
                                <div class="col-md-6">
                                    {!! Form::label('student',trans('tenant.student')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::radio('student','1') !!}
                                </div>
                            </div>
                            <div class="row" id='worker'>
                                <div class="col-md-6">
                                    {!! Form::label('student',trans('tenant.worker')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::radio('student','0',true) !!}
                                </div>
                            </div>
                            <br>
                            <div id="respons_student" class="form-group">
                                <div>
                                    <div class="col-md-6">
                                        {!! Form::label("work_studies",trans('tenant.work')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text("work_studies",$tenant->work_studies) !!}
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-6">
                                        {!! Form::label("school_company",trans('tenant.company')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text("school_company",$tenant->school_company) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!------------- Languages -------->
                    <div class="form-group row ">
                        <div class="col-md-6">
                            {!! Form::label('spoken_languages',trans('tenant.languages')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('spoken_languages',$tenant->spoken_languages) !!}
                        </div>

                    </div>
                    <!------- Contact Preference --------->
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('contact_pref',trans('tenant.contact')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::select('contact_pref',trans('tenant.contact_pref'),['value' => $tenant->contact_preference ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    {!! Form::submit(trans('tenant.save'),['class'=>"btn  btn-viaflats"])!!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!----------- Picture ----------->
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::open(['url'=>'updatePictureTenant','id'=>'updatePictureTenant','files'=>true]) !!}
                {!! Form::label('picture',trans('tenant.picture')) !!}
                <div id="picture_has_error">
                    @if($tenant->profile_picture != NULL)
                        <img class="profilPic" src="profilepics/{{$tenant->profile_picture}}">
                    @else
                        <img class="profilPic" src="profilepics/logov1.png">
                    @endif
                    {!! Form::file('picture') !!}
                </div>
                <div id="picture_error"></div>
                {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                {!! Form::close() !!}
            </div>
        </div>

        <!--------- Trust Center -------->
        <div class="col-md-12">
            <h3>@lang('tenant.trust_center')</h3>
            <div id="trustCenter">
                <div id="successMessageTrustCenter"></div>
                <div class="col-md-6">
                    <h4>More Info About You</h4>
                {!! Form::open(['url'=>'updateTrustCenter','id'=>'updateTrustCenter'])  !!}
                <!--------- Email ---------->
                    <div class="form-group row" id="email_has_error">
                        <div class="col-md-4">
                            {!! Form::label('email',trans('tenant.email')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::email('email',$user->email) !!}
                        </div>
                        <div id="email_error"></div>
                    </div>
                    <!-------- Phone ----------->
                    <div class="form-group row" id="phone_has_error">
                        <div class="col-md-4">
                            {!! Form::label('phone',trans('tenant.phone')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('phone',$user->phone) !!}
                        </div>
                        <div id="phone_error"></div>
                    </div>
                    <!-------- Birth ----------->
                    <div class="form-group row">
                        <div class="col-md-4">
                            {!! Form::label('birth_date',trans('tenant.birth_date')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('birth_date',$tenant->birth_date,['class'=>'datepicker']) !!}
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-md-4">
                            {!! Form::label('birth_place',trans('tenant.birth_place') )!!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('birth_place',$tenant->birth_place) !!}
                        </div>
                    </div>
                    <!-------- Address ---------->
                    <div class="form-group">
                        <div style="text-align: center;">
                            {!! Form::label('Your Address') !!}
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                {!! Form::label('street_number',trans('tenant.street_number')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('street_number',$address_T->street_number) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                {!! Form::label('street_name',trans('tenant.street')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('street_name',$address_T->street) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                {!! Form::label('complement',trans('tenant.complement')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('complement',$address_T->complement) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                {!! Form::label('zip',trans('tenant.zip')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('zip',$address_T->zip) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                {!! Form::label('city',trans('tenant.city')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('city',$address_T->city) !!}
                            </div>
                        </div>
                        <div class=" form-group row">
                            <div class="col-md-4">
                                {!! Form::label('country',trans('tenant.country')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('country',$address_T->country) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>About your parents</h4>
                    <!-------- Name ---------->
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label(trans('tenant.first_name')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('p_first_name',$parent->first_name) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label(trans('tenant.last_name')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('p_last_name',$parent->last_name) !!}
                        </div>
                    </div>
                    <!------- Phone --------->
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label(trans('tenant.phone')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('p_phone',$parent->phone) !!}
                        </div>
                    </div>
                    <!--------- Email -------->
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label(trans('tenant.email')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('p_email',$parent->email) !!}
                        </div>
                    </div>
                    <!-------- Address Parent -------->
                    <div class="form-group row">
                        {!! Form::label('parent_address',trans('tenant.address')) !!}
                        @if(($parent->idAddress == NULL) || ($parent->idAddress == $tenant->idAddress))
                            <div>
                                <div class="col-md-6 " id='Yes'>
                                    {!! Form::label(trans('tenant.yes')) !!}
                                    {!! Form::radio('parent_address',0,true)!!}
                                </div>
                                <div class="col-md-6" id="No">
                                    {!! Form::label(trans('tenant.no')) !!}
                                    {!! Form::radio('parent_address',1) !!}
                                </div>
                                <div id="ParentAddressShow" style="display: none">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_street_number',trans('tenant.street_number')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_street_number') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_street_name',trans('tenant.street')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_street_name') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_complement',trans('tenant.complement')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_complement') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_zip',trans('tenant.zip')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_zip') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_city',trans('tenant.city')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_city') !!}
                                        </div>
                                    </div>
                                    <div class=" form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_country',trans('tenant.country')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_country') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>
                                <div class="col-md-6" id="Yes">
                                    {!! Form::label(trans('tenant.yes')) !!}
                                    {!! Form::radio('parent_address',0)!!}
                                </div>
                                <div class="col-md-6" id="No">
                                    {!! Form::label(trans('tenant.no')) !!}
                                    {!! Form::radio('parent_address',1,true) !!}
                                </div>
                                <div id="ParentAddressShow">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_street_number',trans('tenant.street_number')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_street_number',$address_P->street_number) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_street_name',trans('tenant.street')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_street_name',$address_P->street) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_complement',trans('tenant.complement')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_complement',$address_P->complement) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_zip',trans('tenant.zip')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_zip',$address_P->zip) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_city',trans('tenant.city')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_city',$address_P->city) !!}
                                        </div>
                                    </div>
                                    <div class=" form-group row">
                                        <div class="col-md-4">
                                            {!! Form::label('p_country',trans('tenant.country')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('p_country',$address_P->country) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    {!! Form::submit(trans('tenant.save'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-12" id="updateFileCenter">
            <h3></h3>
            <!----------- ID/Passport ----------->
            <div class="form-group col-md-4">
                {!! Form::open(['url'=>'updateIdentity','files'=>true]) !!}
                {!! Form::label('picture',trans('tenant.identity')) !!}
                <div id="picture_has_error">
                    @if($tenant->identity != NULL)
                        {!! Form::label('You already upload a file ') !!}
                    @else
                        {!! Form::label('You didn\'t upload any file ') !!}
                    @endif
                    {!! Form::file('picture') !!}
                </div>
                <div id="picture_error"></div>
                {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                {!! Form::close() !!}
            </div>
        @if($tenant->student == 1)
            <!---------- Study Agreement ---------->
                <div class="form-group col-md-4" id="Study_agreement">
                    {!! Form::open(['url'=>'updateStudyAgreement','files'=>true]) !!}
                    {!! Form::label('picture',trans('tenant.study_agreement')) !!}
                    <div id="picture_has_error">
                        @if($tenant->study_agreement != NULL)
                            {!! Form::label('You already upload a file ') !!}
                        @else
                            {!! Form::label('You didn\'t upload any file ') !!}
                        @endif
                        {!! Form::file('picture') !!}
                    </div>
                    <div id="picture_error"></div>
                    {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>

                <!---------- Work Agreement ---------->
                <div class="form-group col-md-4" id='Work_agreement' style="display:none;">
                    {!! Form::open(['url'=>'updateWorkAgreement','files'=>true]) !!}
                    {!! Form::label('picture',trans('tenant.work_agreement')) !!}
                    <div id="picture_has_error">
                        @if($tenant->work_agreement != NULL)
                            {!! Form::label('You already upload a file ') !!}
                        @else
                            {!! Form::label('You didn\'t upload any file ') !!}
                        @endif
                        {!! Form::file('picture') !!}
                    </div>
                    <div id="picture_error"></div>
                    {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>
                <!---------- Pay slip ---------->
                <div class="form-group col-md-4" id="Pay_Slip" style="display:none;">
                    {!! Form::open(['url'=>'updatePaySlip','files'=>true]) !!}
                    {!! Form::label('picture',trans('tenant.pay_slip')) !!}
                    <div id="picture_has_error">
                        @if($tenant->pay_slip != NULL)
                            {!! Form::label('You already upload a file ') !!}
                        @else
                            {!! Form::label('You didn\'t upload any file ') !!}
                        @endif
                        {!! Form::file('picture') !!}
                    </div>
                    <div id="picture_error"></div>
                    {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>
        @else
            <!---------- Study Agreement ---------->
                <div class="form-group col-md-4" id="Study_agreement" style="display:none;">
                    {!! Form::open(['url'=>'updateStudyAgreement','files'=>true]) !!}
                    {!! Form::label('picture',trans('tenant.study_agreement')) !!}
                    <div id="picture_has_error">
                        @if($tenant->study_agreement != NULL)
                            {!! Form::label('You already upload a file ') !!}
                        @else
                            {!! Form::label('You didn\'t upload any file ') !!}
                        @endif
                        {!! Form::file('picture') !!}
                    </div>
                    <div id="picture_error"></div>
                    {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>
                <!---------- Work Agreement ---------->
                <div class="form-group col-md-4" id='Work_agreement'>
                    {!! Form::open(['url'=>'updateWorkAgreement','files'=>true]) !!}
                    {!! Form::label('picture',trans('tenant.work_agreement')) !!}
                    <div id="picture_has_error">
                        @if($tenant->work_agreement != NULL)
                            {!! Form::label('You already upload a file ') !!}
                        @else
                            {!! Form::label('You didn\'t upload any file ') !!}
                        @endif
                        {!! Form::file('picture') !!}
                    </div>
                    <div id="picture_error"></div>
                    {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>
                <!---------- Pay slip ---------->
                <div class="form-group col-md-4" id="Pay_Slip">
                    {!! Form::open(['url'=>'updatePaySlip','files'=>true]) !!}
                    {!! Form::label('picture',trans('tenant.pay_slip')) !!}
                    <div id="picture_has_error">
                        @if($tenant->pay_slip != NULL)
                            {!! Form::label('You already upload a file ') !!}
                        @else
                            {!! Form::label('You didn\'t upload any file ') !!}
                        @endif
                        {!! Form::file('picture') !!}
                    </div>
                    <div id="picture_error"></div>
                    {!! Form::submit(trans('tenant.save_file'),['class'=>"btn  btn-viaflats"]) !!}
                    {!! Form::close() !!}
                </div>
            @endif
        </div>
    </div>


    <script>

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

        //Autosave
        $('#aboutYou').on('change', function () {
            saveAbout("");
        });

        //Autosave
        $('#trustCenter').on('change', function () {
            saveTrustCenter("");
        });


    </script>

@endsection