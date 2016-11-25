@extends('layout.landlord')

@section('content')

    <div class="row detail_property_wrapper">
        <div class="col-md-12">
            <h3>Nom de la propriété</h3>


            <div class="col-md-8">
                <div class="row" id="infoProperty">
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
                                <a href="update_estate_room?id={{$singleEstate[0]->idElement}}"><button type="button" id="infoEstate" class="btn form-control btn-default modalOpen">
                                    Update
                                </button></a>
                                <button id="deleteEstate" type="button" class="btn btn-danger form-control">Delete</button>
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

                <div class="row">
                    <h4>Other rooms</h4>

                    @foreach($rooms as $singleRoom)
                        @if($singleRoom->idTypeRoom != $idBedroom)
                            <div class="col-md-12">
                                <h5>@lang('landlord.'.$roomsLabel[$singleRoom->idRoom]->label) - {{$singleRoom->size}}
                                    m²
                                    :</h5>
                                <div class="infoBlock">
                                    <div class="col-md-12">
                                        @foreach($roomsAmenities[$singleRoom->idRoom] as $amenity)
                                            <label class="label label-primary">@lang('landlord.'.$amenity->label)</label>
                                        @endforeach
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
        </div>
    </div>
    {{$rooms[1]}}

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
                        {{Form::submit('submit', ['class' => 'btn btn-default hover_viaflats'])}}
                        {{Form::close()}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        $('.modalOpen').click(function () {
            thisID = $(this).prop('id');
            idParent = $(this).parent().prop('id');
            divGroup = "<div class='form-group'>";
            finDivGroup = "</div>";
            switch (thisID) {

                case 'infoProperty' :

                    content = '{{Form::open(['url' => 'final_preview'])}}';
                    content += divGroup;
                    content += '{{Form::label('size' , 'Size : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::number('size' ,null, ['class' => 'form-control' , 'placeholder' => $property->size])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('address' , 'Address : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('address', null, ['class' => 'form-control' , 'placeholder' => $address->street])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('city' , 'City : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('city', null,['class' => 'form-control' , 'placeholder' => $address->city])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('zip' , 'Zip : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('zip' , null,['class' => 'form-control' , 'placeholder' => $address->zip])}}';
                    content += finDivGroup;

                    content += divGroup;
                    content += '{{Form::label('country' , 'Country : ' , ['class' => 'col-md-4'])}}';
                    content += '{{Form::text('country', null,['class' => 'form-control' , 'placeholder' => $address->country])}}';
                    content += finDivGroup;

                    $('#formModal').html(content);

                    break;

            }

            $('#modal').modal()
        });

        $('#deleteEstate').on('click', function() {

            idEstate = $(this).parent().prop('id');

            $.ajax({
                url: 'delete_estate',
                data: 'idRoom=' + idEstate,
                dataType: 'html',
                success: function (data) {
                    console.log(data);
                    content = '{{Form::open(['url' => 'final_preview'])}}';
                    content += data;
                    content += '{{Form::close()}}';
                    $('#formModal').html(content);
                }
            });

        });
    </script>
@endsection