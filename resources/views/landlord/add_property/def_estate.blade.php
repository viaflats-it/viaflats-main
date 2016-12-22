@extends('layout.landlord')

@section('content')
    <div class="row ">
        <div class="col-md-12">
            <h3>Definition Estate</h3>
            <div class="row">

                <div class="col-md-8">
                    <h4>The property - {{$property->size}}m²</h4>

                    {{$errors->first()}}
                    {!! Form::open(['url' => 'definition_estate' ]) !!}

                    <div class="form-group form-inline row">
                        {!! Form::label('guest', 'Guest number :' , ['class'=>'col-md-4']) !!}
                        {!! Form::number('guest', 1, ['min' => '0','class'=>'form-control size30']) !!}
                        <div class="form-group" style="margin-left: 20px">
                            {!! Form::checkbox('radioShared' , 2, 0,['id'=>'couple']) !!}
                            {!! Form::label('couple') !!}
                        </div>
                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('furnished', 'Furnished :', ['class' => 'col-md-4']) !!}
                        {!! Form::select('furnished', [1 => 'Furnished', 0 => 'Unfurnished'],null, ['class'=>'form-control size30']) !!}
                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('price', 'Total Price :' , ['class'=>'col-md-4']) !!}
                        <div class="input-group col-md-4" style="display: inline-flex">
                            {!! Form::number('price', 0, ['step' => '0.01','min' => '0','class'=>'form-control size40', 'style'=> 'float : right']) !!}
                            <span class="input-group-addon" style="">€/month</span>
                        </div>
                    </div>

                    <div class="form-group form-inline row">

                        {!! Form::label('priceRange', 'Range Price :', ['class' => 'col-md-4']) !!}

                        <div id="rangePriceList" class="form-group col-md-12">
                            <div id="rangePrice1">
                                <div class="col-md-12">
                                    <span class="col-md-3">From month </span>
                                    {!! Form::number('from[]' ,0,
                                        ['readonly', 'class' => 'form-control', 'id' => 'from1']) !!}
                                    <span> --> </span>
                                    {!! Form::number('to[]', null,
                                        ['min' => 0,'class' => 'form-control', 'placeholder'=> 'to...', 'id'=>'to1' ]) !!}
                                </div>
                                <div class="col-md-12">
                                    <span class="col-md-3">Range's Price : </span>
                                    {!! Form::number('priceRange[]', null,
                                            ['id'=>'priceRange1','class' => 'form-control', 'placeholder' => '€ for the range']) !!}
                                    <button  type="button" id="bRange1" class="btn btn-default addRange"
                                             style="float: right; margin-right: 15%">Add a Range
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('fee', 'Extra fee(s) :', ['class'=>'col-md-4']) !!}
                        <button type="button" class="btn btn-viaflats" id="buttonFee" style="margin-bottom: 30px">+</button>

                        <div id="feesList" style="display: none;">
                            @foreach($fees as $fee)
                                <div class="row">
                                    <div class="col-md-4 col-md-push-1">
                                        {!! Form::label('fee-'.$fee->idFee, trans('landlord.'.$fee->label) ,
                                        ["style" => 'color: #89898a; margin-right:10px']) !!}
                                    </div>
                                    <div class="col-md-5">
                                        {!! Form::number('priceFee['.$fee->idFee.']', null , ['class'=>'form-control', 'placeholder' => '€']) !!}
                                    </div>
                                    <div class="slideThree col-md-push-3">
                                        {!! Form::checkbox('slide['.$fee->idFee.']', 1, null, ['style' => 'visibility:hidden', 'id' => 'slideFee['.$fee->idFee.']']) !!}
                                        {!! Form::label('slideFee['.$fee->idFee.']', ' ') !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('miniRent', 'Minimal Rent :', ['class'=>'col-md-4']) !!}
                        <div class="input-group" style="display: inline-flex">
                            {!! Form::number('miniRent', 0, ['min' => '0','class'=>'form-control size40', 'style'=> 'float : right']) !!}
                            <span class="input-group-addon" style="">Days</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::radio('bookingInfo' , 0, 0,['id'=>'book_nothing']) !!}

                        {!! Form::label('book_nothing') !!}
                        {!! Form::radio('bookingInfo' , 1, 0,['id'=>'book_flex']) !!}
                        {!! Form::label('book_flex') !!}
                        {!! Form::radio('bookingInfo' , 2, 0
                                                , ['id'=>'book_preference']) !!}
                        {!! Form::label('book_preference') !!}
                    </div>

                    <div class="form-group form-inline row" id="booking_flex" style="display:none">
                        {!! Form::label('bookingFlex', 'Booking Flexibility :' , ['class'=>'col-md-4']) !!}
                        {!! Form::number('bookingFlex', 0,
                                        ['min' => '0','class'=>'form-control size30']) !!}
                    </div>


                    <div id="booking_preference" style="display:none">
                        <div class="form-group form-inline row">
                            {!! Form::label('prefCheckin', 'Check in Preference :', ['class'=>'col-md-4']) !!}
                            <div class="input-group" style="display: inline-flex">
                                {!! Form::number('prefCheckin', 0, [
                                                'max'=> '31' , 'min' => '0','class'=>'form-control size40',
                                                        'style'=> 'float : right']) !!}
                                <span class="input-group-addon" style="">each month</span>
                            </div>
                        </div>

                        <div class="form-group form-inline row">
                            {!! Form::label('prefCheckout', 'Check out Preference :', ['class'=>'col-md-4']) !!}
                            <div class="input-group" style="display: inline-flex">
                                {!! Form::number('prefCheckout', 0, ['max'=> '31' ,
                                            'min' => '0','class'=>'form-control size40', 'style'=> 'float : right']) !!}
                                <span class="input-group-addon" style="">each month</span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group form-inline row">
                        {!! Form::label('windows', 'Windows number :', ['class' => 'col-md-4']) !!}
                        {!! Form::number('windows', 0, ['min' => '0','class'=>'form-control size30']) !!}
                        <div class="form-group">
                            {!! Form::select('glazing' , [1 => 'Double Glazing' , 0 => 'Simple Glazing'],0,
                                 ['class' => 'form-control']) !!}
                        </div>
                    </div>


                    <div class="form-group form-inline row">
                        {!! Form::label('disposition', 'Disposition : ', ['class' => 'col-md-4']) !!}
                        {!! Form::select('disposition', [1 => 'Street Side', 0 => 'Other'], null,
                                        ['class' => 'form-control']) !!}
                    </div>


                    <div class="form-group form-inline row">
                        {!! Form::label('rentalSub', 'Rental subsidies available :', ['class'=>'col-md-4']) !!}
                        {!! Form::select('rentalSub', [0 => 'Rental Sub unavailable', 1 => 'Rental Sub available'],
                                        null, ['class'=>'form-control']) !!}
                    </div>


                    <div class="form-group row">
                        {!! Form::label('restriction', 'Restriction :', ['class'=>'col-md-4']) !!}
                        <div class="form-inline">
                            @foreach($restrictions as $restriction)
                                {!! Form::checkbox('restriction[]', $restriction->idRestriction,0,
                                        ['class'=>'form-control', 'id' => 'restriction-'.$restriction->idRestriction]) !!}
                                {!! Form::label('restriction-'.$restriction->idRestriction, $restriction->label ,
                                ["style" => 'color: #89898a; margin-right:10px']) !!}
                            @endforeach
                        </div>
                    </div>



                    {!! Form::submit('Update', ['class' => 'btn btn-default hover_viaflats form-control']) !!}
                    {!! Form::close() !!}

                </div>
                <div class="col-md-4 def-estate">
                    <h4>Recap</h4>
                    <label>Type : </label> <span>{{$type}}</span>
                    <br/>
                    <label>Rooms :</label>
                    <ul class="list-inline">
                        @foreach($roomsLabel as $roomLabel)
                            <li>@lang('landlord.'.$roomLabel->label)</li>
                        @endforeach
                    </ul>
                    <br/>

                    <label>City :</label> <span>{{$address->city}}</span>
                    <br/>

                    <label>Area :</label> <span>{{$area->label}}</span>
                    <br/>

                    <label>Address :</label>
                    <p>{{$address->street_number . ',' . $address->street . '  '. $address->complement}}<p>
                    <p> {{$address->zip . ' ' . $address->city }}</p>
                    <p>{{$address->country}} </p>

                    <label>Commodities Nearby :</label>
                    <p>Nothing because I am in a black hole</p>

                    <div class="delimiter"></div>
                    @foreach($rooms as $room)
                        <label>About the @lang('landlord.'.$roomsLabel[$room->idRoom]->label) - {{$room->size}} m²
                            : </label>
                        <ul class="list-inline">
                            @foreach($roomsAmenities[$room->idRoom] as $roomAmenity)
                                <li>@lang('landlord.'.$roomAmenity->label)</li>
                            @endforeach
                        </ul>
                        <br/>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


    <script>
        $('input[name="dateIn"]').daterangepicker({
            "startDate": $.datepicker.formatDate('mm/dd/yy', new Date()),

        });

        $('#couple').on('change', function() {
            if (this.checked)
            {
                $('#guest').val(2);
                $('#guest').prop('readOnly', true);
            }
            else
            {
                $('#guest').val(1);
                $('#guest').prop('readOnly', false);
            }
        });

        $('#book_flex').on('click', function () {
            $('#booking_preference').hide();
            $('#booking_flex').show();
        });

        $('#book_preference').on('click', function () {
            $('#booking_flex').hide();
            $('#booking_preference').show();
        });

        $('#book_nothing').on('click', function () {
            $('#booking_preference').hide();
            $('#booking_flex').hide();
        });

        $('#buttonShortStay').on('click', function () {
            var short = $('#shortStay');
            if (short.css('display') == 'none') {
                short.show();
            }
            else {
                short.hide();
                $("#shortStay input[type=number]").val(0);
            }
        });

        $('#buttonFee').on('click', function() {
            var fees = $('#feesList');
            if (fees.css('display') == 'none') {
                $('#buttonFee').text('-');
                fees.show();
            }
            else {
                $('#buttonFee').text('+');

                fees.hide();
            }
        });

        $('#rangePriceList').on('click', '.addRange', function () {
            clone = $('#rangePrice1').clone();
            var regex = /[0-9]+/g;
            var thisId = parseInt(regex.exec(this.id)[0]);
            var nextId = thisId + 1;
            clone.find('#from1').val($('#to'+thisId).val());
            clone.find('#to1').val('');
            clone.find('#priceRange1').val('');

            clone.find('#from1').attr('id' , 'from'+nextId);
            clone.find('#to1').attr('id' , 'to'+nextId);
            clone.find('#priceRange1').attr('id', 'priceRange'+nextId);
            clone.find('#bRange1').attr('id', 'bRange'+nextId);

            clone.attr('id', 'rangePrice'+nextId);

            clone.children().appendTo('#rangePriceList');
        });
    </script>
@endsection