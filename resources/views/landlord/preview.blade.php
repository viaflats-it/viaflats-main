@extends('layout.landlord')

@section('content')

    <div class="row detail_property_wrapper">
        <div class="col-md-12">
            <h3>Nom de la propriété</h3>


            <div class="col-md-8">
                <div class="row" id="divInfoProperty">
                    <h4>Furnished {{$type}}</h4>
                    <div class="col-md-6">
                        <div class="infoBlock">
                            <label>Size :</label>
                            <span>{{$property->size}} m²</span> <br/>
                            <label>BedRooms :</label>
                            <span>{{$countInfo['bedroom']}}</span> <br/>
                            <label>BathRooms :</label>
                            <span>{{$countInfo['bathroom']}}</span> <br/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="infoBlock">
                            <label>Address :</label>
                            <span>{{$address->street}}</span> <br/>
                            <label>City :</label>
                            <span>{{$address->city}}</span> <br/>
                            <label>Zip :</label>
                            <span>{{$address->zip}}</span>
                            <label>Country :</label>
                            <span>{{$address->country}}</span>
                        </div>
                    </div>
                    <button id="infoProperty" class="btn btn-default hover_viaflats modalOpen">Update</button>
                </div>


                @if(!isset($estate))

                    @foreach($estatesList as $key => $singleEstate)

                        <div class="row">
                            <h4> @lang('landlord.'.($singleEstate[0]->furnished ? 'furnished' : 'unfurnished'))
                                @lang('landlord.'.$roomsLabel[$singleEstate[0]->idElement]->label)</h4>

                            <div class="col-md-5">
                                <div class="infoBlock">
                                    <label>Size :</label>
                                    <span>{{$roomEstateList[$singleEstate[0]->idElement]->size}} m²</span> <br/>
                                    <label>Guest :</label>
                                    <span>{{$singleEstate[0]->guest_nb}}</span>
                                    <br/>
                                    <label>@if($singleEstate[0]->shared == 0)
                                            Private
                                        @elseif($singleEstate[0]->shared == 1)
                                            Shared
                                        @else
                                            Couple
                                        @endif
                                    </label>
                                    <br/>
                                    <label>{{$singleEstate[0]->rental_sub == 0 ? 'Rental sub unavailable' : 'Rental sub available'}}</label>
                                    <br/>
                                    <label>{{$singleEstate[0]->windows}} Windows</label>
                                    <br/>
                                    <label>{{$singleEstate[0]->street_side == 0  ? 'Not street Side' : 'Street side'}}</label>

                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="infoBlock">
                                    <label>Rent : </label>
                                    <span>{{$singleEstate[0]->rent}} €</span> <br/>
                                    @if(unserialize($singleEstate[0]->range_period)[0]['to'] != null)
                                        <label>Rent Range : </label>  <br/>
                                        @foreach(unserialize($singleEstate[0]->range_period) as $range)
                                            <span>{{$range['from'] == 0 ? '' : '> ' . $range['from'] . ' Month'}}</span>
                                            <span> < {{$range['to']}} Month </span>
                                            <span>- Rent : {{$range['price']}} €</span> <br/>
                                        @endforeach

                                    @endif

                                    @if($singleEstate[0]->booking_flexibility != 0)
                                        <label>Booking Flexibility : </label>
                                        <span>{{$singleEstate[0]->booking_flexibility}} Days</span>
                                    @endif

                                    @if($singleEstate[0]->mini_stay != 0)
                                        <label>Minimum stay : </label>
                                        <span>{{$singleEstate[0]->mini_stay}}</span>
                                    @endif

                                    @if($singleEstate[0]->checkin_preference != 0)
                                        <label>Checkin Preference : </label>
                                        <span>{{$singleEstate[0]->checkin_preference}}</span>
                                    @endif

                                    @if($singleEstate[0]->checkout_preference != 0)
                                        <label>Checkout Preference : </label>
                                        <span>{{$singleEstate[0]->checkin_preference}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-2" id="{{$singleEstate[0]->idElement}}">
                                <a href="update_estate_room?id={{$singleEstate[0]->idElement}}">
                                    <button type="button" id="infoEstate"
                                            class="btn form-control btn-default">
                                        Update
                                    </button>
                                </a>
                                <button id="deleteEstate{{$singleEstate[0]->idElement}}" type="button"
                                        class="btn btn-danger form-control"
                                        style={{$singleEstate[0]->status != 1 ? '' : 'display:none'}}>Delete
                                </button>
                                <button id="ReactivateEstate{{$singleEstate[0]->idElement}}" type="button"
                                        class="btn btn-info form-control"
                                        style={{$singleEstate[0]->status == 1 ? '' : 'display:none'}}>Activate
                                </button>
                            </div>

                            <div class="col-md-12">
                                <div class="infoBlock">
                                    <div class="col-md-12">
                                        @foreach($roomsAmenities[$singleEstate[0]->idElement] as $roomAmenity)
                                            <label class="label label-primary">@lang('landlord.'.$roomAmenity->label)</label>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="row" id="otherRooms">
                    <h4>Other rooms</h4>

                    @foreach($rooms as $singleRoom)
                        @if($singleRoom->idTypeRoom != $idBedroom)
                            <div id="divRoom{{$singleRoom->idRoom}}">
                                <div class="col-md-1" style="padding-top: 10px">
                                    <i class="fa fa-times-circle" id="deleteRoom{{$singleRoom->idRoom}}"
                                       style="color:red; cursor: pointer" aria-hidden="true"></i>

                                    <i class="fa fa-cogs" id="editRoom{{$singleRoom->idRoom}}"
                                       style="color:red; cursor: pointer" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-11">
                                    <h5>@lang('landlord.'.$roomsLabel[$singleRoom->idRoom]->label)
                                        - {{$singleRoom->size}}
    a                                     m²
                                        :</h5>
                                    <div class="infoBlock">
                                        <div class="col-md-12">
                                            @foreach($roomsAmenities[$singleRoom->idRoom] as $amenity)
                                                <label class="label label-primary">@lang('landlord.'.$amenity->label)</label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <h4>Prix : 1500 €</h4>
            </div>
            <a href="appointment">
                <button type="button" class="btn btn-default form-control hover_viaflats" style="text-align: center;">
                    Finaliser
                </button>
            </a>
        </div>
    </div>

    <div id="modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-inline ">
                        <div id="formModal"></div>
                        {{Form::close()}}
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-default" id="updateProperty">Update</button>--}}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script>

        var submitVar = "";
        $('.modalOpen').click(function () {
            thisID = $(this).prop('id');
            idParent = $(this).parent().prop('id');
            divGroup = "<div class='form-group'>";
            finDivGroup = "</div>";


            switch (thisID) {

                case 'infoProperty' :

                    content = '{{Form::open(['url' => 'final_preview' , 'id' => 'formUpdateProperty'])}}';
                    content += '{{Form::hidden('idProperty', $property->idProperty)}}';
                    content += divGroup;
                    content += '{{Form::label('size' , 'Size : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::number('size' ,$property->size, ['class' => 'form-control'])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('address' , 'Address : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('address', $address->street, ['class' => 'form-control'])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('city' , 'City : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('city', $address->city, ['class' => 'form-control'])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('zip' , 'Zip : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('zip' , $address->zip,['class' => 'form-control'])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('country' , 'Country : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('country', $address->country,['class' => 'form-control'])}}';
                    content += finDivGroup;
                    submitVar = '{{Form::submit('Update', ['id' => 'updateProperty', 'class' => 'btn btn-default'])}}';

                    $('#updateProperty').remove();
                    $('#updateRoom').remove();

                    $('.modal-footer').append(submitVar);

                    $('#formModal').html(content);

                    break;


            }

            $('#modal').modal()
        });


        $("i[id^='deleteRoom']").on('click', function () {
            idEstate = $(this).prop('id');
            idEstate = idEstate.replace('deleteRoom', '');

            $.ajax({
                method: "POST",
                url: 'delete_room',
                data: {
                    'idRoom': idEstate,
                    "_token": "{{ csrf_token() }}"
                },
                success: function () {
                    $('#divRoom' + idEstate).hide();
                }


            });

        });

        $(document).on('click', "i[id^='editRoom']", function () {
            idEstate = $(this).prop('id');
            idEstate = idEstate.replace('editRoom', '');
            submitVar = '{{Form::submit('Update', ['id' => 'updateRoom', 'class' => 'btn btn-default'])}}';
            $.ajax({
                method: "GET",
                url: 'get_room',
                data: {
                    'idRoom': idEstate,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#formModal').html(data);
                    $('#updateProperty').remove();
                    $('#updateRoom').remove();
                    $('.modal-footer').append(submitVar);
                    $('#modal').modal()
                }


            });

        });

        $("button[id^='deleteEstate']").on('click', function () {
            idEstate = $(this).parent().prop('id');

            $.ajax({
                method: "POST",
                url: 'delete_estate',
                data: {
                    'idRoom': idEstate,
                    "_token": "{{ csrf_token() }}"
                },
                success: function () {
                    $('#deleteEstate' + idEstate).hide();
                    $('#ReactivateEstate' + idEstate).show();
                }
            });

        });

        $("button[id^='ReactivateEstate']").on('click', function () {

            idEstate = $(this).parent().prop('id');

            $.ajax({
                method: "POST",
                url: 'activate_estate',
                data: {
                    'idRoom': idEstate,
                    "_token": "{{ csrf_token() }}"
                },
                success: function () {
                    $('#deleteEstate' + idEstate).show();
                    $('#ReactivateEstate' + idEstate).hide();
                }
            });

        });

        $('.modal-footer').on('click', '#updateProperty', function () {
            var $form = $('#formUpdateProperty');

            $.ajax({
                method: "POST",
                url: 'update_property',
                data: {
                    'data': $form.serialize(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function () {
                    $('#modal').modal('hide');
                    $('#divInfoProperty').load('final_preview #divInfoProperty', function () {
                    });
                }
            });
        });

        $('.modal-footer').on('click', '#updateRoom', function () {
            var $form = $('#formUpdateRoom');
            var idRoom = $('#formUpdateRoom input[name=idRoom]').val();
            console.log('ok');
            $.ajax({
                method: "POST",
                url: 'update_room',
                data: {
                    'data': $form.serialize(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function () {
                    $('#modal').modal('hide');
                    $('#divRoom' + idRoom).load('final_preview #divRoom' + idRoom, function () {
                    });
                }
            });
        });


    </script>
@endsection