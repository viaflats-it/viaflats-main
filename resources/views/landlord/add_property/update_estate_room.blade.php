@extends('layout.landlord')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Definition Estate</h3>
            <div class="row">

                <div class="col-md-8">
                    {{$errors->first()}}
                    <h4>The room - {{$room->size}}m²</h4>

                    {!! Form::open(['url' => 'update_estate_room', 'method' => 'post' ]) !!}
                    {!! Form::hidden('idEstate' , $estate->idEstate)!!}

                    <div class="form-group form-inline row">
                        {!! Form::label('guest', 'Guest number :' , ['class'=>'col-md-4']) !!}
                        {!! Form::number('guest', $estate->guest_nb,
                                ['required', 'placeholder'=> 'Guest Number','min' => '0','class'=>'form-control col-md-4']) !!}
                        <div class="form-group" style="margin-left: 20px">
                            {!! Form::radio('radioShared' , 1, $estate->shared == 1 ? '0' : '1',['id'=>'shared']) !!}
                            {!! Form::label('shared') !!}
                            {!! Form::radio('radioShared' , 2, $estate->shared == 2 ? '0' : '1',['id'=>'couple']) !!}
                            {!! Form::label('couple') !!}
                        </div>

                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('price', 'Rent Price :' , ['class' => 'col-md-4']) !!}
                        {!! Form::number('price' , $estate->rent,
                               ['min' => 0,'class' => 'form-control', 'placeholder'=> '€/month' ]) !!}

                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('priceRange', 'Range Price :', ['class' => 'col-md-4']) !!}
                        <div id="rangePriceList" class="form-group col-md-12">
                            @foreach(unserialize($range_period) as $key => $period)
                                <div id="rangePrice{{$key}}">
                                    <div class="col-md-12">
                                        <span class="col-md-3">From month </span>
                                        {!! Form::number('from[]' ,$period['from'],
                                            ['class' => 'form-control', 'id' => 'from'.$key]) !!}
                                        <span> --> </span>
                                        {!! Form::number('to[]', $period['to'],
                                            ['min' => 0,'class' => 'form-control', 'id'=>'to'.$key ]) !!}
                                    </div>
                                    <div class="col-md-12">
                                        <span class="col-md-3">Range's Price : </span>
                                        {!! Form::number('priceRange[]', $period['price'],
                                                ['id'=>'priceRange'.$key,'class' => 'form-control']) !!}

                                        <button type="button" id="bRange{{$key}}" class="btn btn-default addRange"
                                                {{$key == ( count(unserialize($range_period)) -1 ) ? ' ' : 'disabled'}}

                                                style="margin-left:20px">Add Range
                                        </button>
                                        <button type="button" id="bRangeDelete{{$key}}" class="btn btn-default delRange"
                                                {{$key == ( count(unserialize($range_period)) -1 ) ? ' ' : 'disabled'}}

                                                style=" margin-right: 15%">Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('fee', 'Extra fee(s) :', ['class'=>'col-md-4']) !!}
                        <button type="button" class="btn btn-viaflats" id="buttonFee" style="margin-bottom: 30px">+
                        </button>

                        <div id="feesList" style="display: none;">
                            @foreach($fees as $fee)

                                <div class="row">
                                    <div class="col-md-4 col-md-push-1">
                                        {!! Form::label('fee-'.$fee->idFee, trans('landlord.'.$fee->label) ,
                                        ["style" => 'color: #89898a; margin-right:10px']) !!}
                                    </div>
                                    <div class="col-md-5">
                                        {!! Form::number('priceFee['.$fee->idFee.']',
                                                    isset($feesEstate[$fee->idFee]) ? $feesEstate[$fee->idFee]->price : null , ['class'=>'form-control', 'placeholder' => '€']) !!}
                                    </div>
                                    <div class="slideThree col-md-push-3">
                                        {!! Form::checkbox('slide['.$fee->idFee.']', 1,
                                        isset($feesEstate[$fee->idFee]) ? $feesEstate[$fee->idFee]->monthly == 1 ? 0 : 1 : 0 ,
                                                  ['style' => 'visibility:hidden', 'id' => 'slideFee['.$fee->idFee.']']) !!}
                                        {!! Form::label('slideFee['.$fee->idFee.']', ' ') !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group form-inline row">
                        {!! Form::label('miniRent', 'Minimal Rent :', ['class'=>'col-md-4']) !!}
                        <div class="input-group" style="display: inline-flex">
                            {!! Form::number('miniRent', $estate->mini_stay, ['min' => '0','class'=>'form-control size40', 'style'=> 'float : right']) !!}
                            <span class="input-group-addon" style="">Days</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::radio('bookingInfo' , 0, $estate->booking_flexibility != 0 ? 0 :
                                  $estate->checkin_preference != 0 || $estate->checkout_preference != 0 ? 0: 1,['id'=>'book_nothing']) !!}

                        {!! Form::label('book_nothing') !!}
                        {!! Form::radio('bookingInfo' , 1, $estate->booking_flexibility != 0 ? 1:0 ,['id'=>'book_flex']) !!}
                        {!! Form::label('book_flex') !!}
                        {!! Form::radio('bookingInfo' , 2, $estate->checkout_preference != 0 || $estate->checkin_preference? 1:0
                                                , ['id'=>'book_preference']) !!}
                        {!! Form::label('book_preference') !!}
                    </div>

                    <div class="form-group form-inline row" id="booking_flex" style="display:none">
                        {!! Form::label('bookingFlex', 'Booking Flexibility :' , ['class'=>'col-md-4']) !!}
                        {!! Form::number('bookingFlex', $estate->booking_flexibility,
                                        ['min' => '0','class'=>'form-control size30']) !!}
                    </div>


                    <div id="booking_preference" style="display:none">
                        <div class="form-group form-inline row">
                            {!! Form::label('prefCheckin', 'Check in Preference :', ['class'=>'col-md-4']) !!}
                            <div class="input-group" style="display: inline-flex">
                                {!! Form::number('prefCheckin', $estate->checkin_preference, [
                                                'max'=> '31' , 'min' => '0','class'=>'form-control size40',
                                                        'style'=> 'float : right']) !!}
                                <span class="input-group-addon" style="">each month</span>
                            </div>
                        </div>

                        <div class="form-group form-inline row">
                            {!! Form::label('prefCheckout', 'Check out Preference :', ['class'=>'col-md-4']) !!}
                            <div class="input-group" style="display: inline-flex">
                                {!! Form::number('prefCheckout', $estate->checkout_preference, ['max'=> '31' ,
                                            'min' => '0','class'=>'form-control size40', 'style'=> 'float : right']) !!}
                                <span class="input-group-addon" style="">each month</span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group form-inline row">
                        {!! Form::label('windows', 'Windows number :', ['class' => 'col-md-4']) !!}
                        {!! Form::number('windows', $estate->windows, ['min' => '0','class'=>'form-control size30']) !!}
                        <div class="form-group">
                            {!! Form::select('glazing' , [1 => 'Double Glazing' , 0 => 'Simple Glazing'],
                             $estate->double_glazing == 1  ? 1 : 0,
                                 ['class' => 'form-control']) !!}
                        </div>
                    </div>


                    <div class="form-group form-inline row">
                        {!! Form::label('disposition', 'Disposition : ', ['class' => 'col-md-4']) !!}
                        {!! Form::select('disposition', [1 => 'Street Side', 0 => 'Other'], $estate->street_side,
                                        ['class' => 'form-control']) !!}
                    </div>


                    <div class="form-group form-inline row">
                        {!! Form::label('rentalSub', 'Rental subsidies available :', ['class'=>'col-md-4']) !!}
                        {!! Form::select('rentalSub', [0 => 'Rental Sub unavailable', 1 => 'Rental Sub available'],
                                        $estate->rental_sub, ['class'=>'form-control']) !!}
                    </div>


                    <div class="form-group row">
                        {!! Form::label('restriction', 'Restriction :', ['class'=>'col-md-4']) !!}
                        <div class="form-inline">
                            @foreach($restrictions as $restriction)
                                {!! Form::checkbox('restriction[]', $restriction->idRestriction,
                                            isset($restrictionsEstate[$restriction->idRestriction]) ? 1 : 0,
                                        ['class'=>'form-control', 'id' => 'restriction-'.$restriction->idRestriction]) !!}
                                {!! Form::label('restriction-'.$restriction->idRestriction, $restriction->label ,
                                ["style" => 'color: #89898a; margin-right:10px']) !!}
                            @endforeach
                        </div>
                    </div>


                    @if (isset($bathrooms))
                        <div class="form-group form-inline row">
                            {!! Form::label('privateBathroom', 'Private bathroom : ' , ['class' => 'col-md-4']) !!}
                            <div class="form-group">
                                {!! Form::radio('privateBathroom', 1 , isset($privateRooms['bathroom'])  ? 1 : 0,
                                ['id' => 'privateBathRoomYes']) !!}
                                {!! Form::label('privateBathRoomYes' , 'Yes') !!}
                                {!! Form::radio('privateBathroom', 0, isset($privateRooms['bathroom']) ? 0 : 1, ['id' => 'privateBathRoomNo']) !!}
                                {!! Form::label('privateBathRoomNo' , 'No') !!}
                            </div>
                        </div>

                        <div id="selectBathroom" class="form-group form-inline row col-md-12 col-md-push-4"
                             style="display:none">
                            {!! Form::label('bathroomSize' , 'Bathroom Size : ') !!}
                            {!! Form::select('bathroomSize', $bathrooms , $privateRooms['bathroom']->idRoom,['class' => 'form-control']) !!}
                            {!! Form::label('m²') !!}
                        </div>
                    @endif

                    @if (isset($toilets))
                        <div class="form-group form-inline row">
                            {!! Form::label('privateToilet', 'Private Toilet : ' , ['class' => 'col-md-4']) !!}
                            <div class="form-group">
                                {!! Form::radio('privateToilet', 1 , isset($privateRooms['toilet']) ? 1 : 0,
                                ['id' => 'privateToiletYes']) !!}
                                {!! Form::label('privateToiletYes' , 'Yes') !!}
                                {!! Form::radio('privateToilet', 0,  isset($privateRooms['toilet']) ? 0 : 1, ['id' => 'privateToiletNo']) !!}
                                {!! Form::label('privateToiletNo' , 'No') !!}
                            </div>
                        </div>

                        <div id="selectToilet" class="form-group form-inline row col-md-12 col-md-push-4"
                             style="display:none">
                            {!! Form::label('toiletSize' , 'Toilet Size : ') !!}
                            {!! Form::select('toiletSize', $toilets , isset($privateRooms['toilet']->idRoom) ?
                                                $privateRooms['toilet']->idRoom : 0,['class' => 'form-control']) !!}
                            {!! Form::label('m²') !!}
                        </div>
                    @endif

                    @if (isset($kitchens))
                    <div class="form-group form-inline row">
                        {!! Form::label('privateKitchen', 'Private Kitchen : ' , ['class' => 'col-md-4']) !!}
                        <div class="form-group">
                            {!! Form::radio('privateKitchen', 1 , isset($privateRooms['kitchen']) ? 1 : 0,
                            ['id' => 'privateKitchenYes']) !!}
                            {!! Form::label('privateKitchenYes' , 'Yes') !!}
                            {!! Form::radio('privateKitchen', 0, isset($privateRooms['kitchen']) ? 0 : 1, ['id' => 'privateKitchenNo']) !!}
                            {!! Form::label('privateKitchenNo' , 'No') !!}
                        </div>
                    </div>

                    <div id="selectKitchen" class="form-group form-inline row col-md-12 col-md-push-4"
                         style="display:none">
                        {!! Form::label('kitchenSize' , 'Kitchen Size : ') !!}
                        {!! Form::select('kitchenSize', $kitchens , isset($privateRooms['kitchen']->idRoom) ?
                                            $privateRooms['kitchen']->idRoom : 0,['class' => 'form-control']) !!}
                        {!! Form::label('m²') !!}
                    </div>
                    @endif

                    {{--<div class="form-group row">--}}
                    {{--{!! Form::label('availability', 'Availabilities : ', ['class'=>'col-md-4']) !!}--}}
                    {{--<div class="form-inline">--}}
                    {{--{!! Form::text('dateIn' ,null,  ['class' => 'form-control']) !!}--}}
                    {{--</div>--}}

                    {{--</div>--}}

                    {!! Form::submit('Update', ['class' => 'btn btn-default hover_viaflats form-control']) !!}
                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>


    <script>


        $('input:radio[name="radioShared"]').change(
                function () {
                    if (this.id == 'couple') {
                        $('input[name="guest"]').val(2);
                        $('input[name="guest"]').prop('readonly', true);
                    }
                    else if (this.id == "shared") {
                        $('input[name="guest"]').val(0);
                        $('input[name="guest"]').prop('readonly', false);
                    }
                });


        $(document).ready(function () {
            if ($('#book_flex').prop('checked') == true) {
                $('#booking_flex').show();
            }
            else if ($('#book_preference').prop('checked') == true) {
                $('#booking_preference').show();
            }

            if ($('#privateBathRoomYes').prop('checked') == true) {
                $('#selectBathroom').show();
            }

            if ($('#privateToiletYes').prop('checked') == true) {
                $('#selectToilet').show();
            }

        });
        $('input[name="dateIn"]').daterangepicker({
            "startDate": $.datepicker.formatDate('mm/dd/yy', new Date()),

        });

        $('#book_flex').on('click', function () {
            $('#booking_preference').hide();
            $('input[name="prefCheckin"]').val(0);
            $('input[name="prefCheckout"]').val(0);
            $('#booking_flex').show();
        });

        $('#book_preference').on('click', function () {
            $('#booking_flex').hide();
            $('input[name="bookingFlex"]').val(0);
            $('#booking_preference').show();
        });

        $('#book_nothing').on('click', function () {
            $('#booking_preference').hide();
            $('#booking_flex').hide();
            $('input[name="bookingFlex"]').val(0);
            $('input[name="prefCheckin"]').val(0);
            $('input[name="prefCheckout"]').val(0);
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

        $('#buttonFee').on('click', function () {
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

        $('input:radio[name="privateBathroom"]').change(
                function () {
                    if (this.id == 'privateBathRoomYes') {
                        $('#selectBathroom').show();
                    }
                    else if (this.id == "privateBathRoomNo") {
                        $('#selectBathroom').hide();
                    }
                });

        $('input:radio[name="privateToilet"]').change(
                function () {
                    if (this.id == 'privateToiletYes') {
                        $('#selectToilet').show();
                    }
                    else if (this.id == "privateToiletNo") {
                        $('#selectToilet').hide();
                    }
                });


        $('input:radio[name="privateKitchen"]').change(
                function () {
                    if (this.id == 'privateKitchenYes') {
                        $('#selectKitchen').show();
                    }
                    else if (this.id == "privateKitchenNo") {
                        $('#selectKitchen').hide();
                    }
                });

        $('#rangePriceList').on('click', '.addRange', function () {
            clone = $('#rangePrice0').clone();
            var regex = /[0-9]+/g;
            var thisId = parseInt(regex.exec(this.id)[0]);
            var nextId = thisId + 1;

            clone.find('#from0').val($('#to' + thisId).val());
            clone.find('#to0').val('');
            clone.find('#priceRange0').val('');

            clone.find('#from0').attr('id', 'from' + nextId);
            clone.find('#to0').attr('id', 'to' + nextId);
            clone.find('#priceRange0').attr('id', 'priceRange' + nextId);
            clone.find('#bRange0').attr('id', 'bRange' + nextId);

            clone.attr('id', 'rangePrice' + nextId);


            $(this).prop('disabled', true);
            clone.find('#bRange' + nextId).prop('disabled', false);


            clone.children().appendTo('#rangePriceList');
        })

        $('#rangePriceList').on('click', '.delRange',function() {
            var regex = /[0-9]+/g;
            var thisId = parseInt(regex.exec(this.id)[0]);

            if(thisId > 0)
            {
                var prevId = thisId -1 ;
                $('#bRange'+prevId).prop('disabled' , false);
                $('#bRangeDelete'+prevId).prop('disabled' , false);
                $('#rangePrice'+thisId).remove();
            }


        });
    </script>
@endsection