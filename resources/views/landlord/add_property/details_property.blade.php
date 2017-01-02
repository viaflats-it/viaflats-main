@extends('layout.landlord')

@section('content')
    <div class="row detail_property_wrapper">
        <div class="col-md-12">
            <h3>@lang('landlord.details')</h3>
            <div class="row ">
                <div class="col-md-8 group_details">

                    {!! Form::open(['url' => 'details_property', 'id' => 'detail_property', 'class'=>'form-horizontal']) !!}
                    {!! Form::hidden('ID', '5') !!}
                    {!! Form::label('type' , trans('landlord.type'). ' :') !!}
                    <div class="form-group">
                        <input type='radio' name='type' value='0' id="radio_home"/><label for="radio_home"></label>
                        <input type='radio' name='type' value='1' id="radio_apartment"/><label
                                for="radio_apartment"></label>
                        <input type='radio' name='type' value='2' id="radio_studio"/><label
                                for="radio_studio"></label>
                        @if ($errors->has('type'))
                            <span class="help-block">
                                        <strong>{{$errors->first('type')}}</strong>
                                </span>
                        @endif
                    </div>

                    {!! Form::label('room_type', trans('landlord.room_type').' :') !!}
                    <div class="form-group">
                        <input type='radio' name='room_type' value='0' id="radio_entire"/><label
                                for="radio_entire"></label>
                        <input type='radio' name='room_type' value='1' id="radio_shared"/><label
                                for="radio_shared"></label>
                        @if ($errors->has('room_type'))
                            <span class="help-block">
                                        <strong>{{$errors->first('room_type')}}</strong>
                                </span>
                        @endif
                    </div>

                    {!! Form::label('Tsize', trans('landlord.Tsize').' :')!!}
                    <div class="input-group size30 {{$errors->has('Tsize') ? 'has-error' : ''}}">
                        {!! Form::number('Tsize', null, ['class'=>'form-control', 'id'=>'Tsize']) !!}
                        <div class="input-group-addon" style="font-size: 1.2em;background-color: #9982bb;color:#ecf0f1">
                            m²
                        </div>
                    </div>

                    <h3>
                        {!! Form::label('address', trans('landlord.address')) !!}
                    </h3>

                    <div class="form-group {{$errors->has('streetNumber') ? 'has-error' : ''}} ">
                        {!! Form::label('streetNumber', trans('landlord.streetNumber').' :',
                                        ['class'=>'col-md-3 control-label', ]) !!}
                        <div class="col-sm-4">
                            {!! Form::number('streetNumber', null,
                                  ['class'=>'form-control', 'id'=>'streetNumber', 'placeholder'=> trans('landlord.streetNumber')]) !!}
                        </div>
                        @if ($errors->has('streetNumber'))
                            <br/>
                            <span class="help-block">
                                        <strong>{{$errors->first('streetNumber')}}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group {{$errors->has('street') ? 'has-error' : ''}}">
                        {!! Form::label('street', trans('landlord.street').' :',
                                        ['class'=>'col-md-3 control-label', ]) !!}
                        <div class="col-sm-8">
                            {!! Form::text('street', null,
                                 ['class'=>'form-control', 'id'=>'street', 'placeholder'=> trans('landlord.street')]) !!}
                       </div>
                        @if ($errors->has('street'))
                            <br/>
                            <span class="help-block">
                                        <strong>{{$errors->first('street')}}</strong>
                                </span>
                        @endif
                   </div>

                   <div class="form-group {{$errors->has('complement') ? 'has-error' : ''}}">
                       {!! Form::label('complement', trans('landlord.complement').' :',
                                       ['class'=>'col-md-3 control-label', ]) !!}
                       <div class="col-sm-8">
                           {!! Form::text('complement', null,
                                 ['class'=>'form-control', 'id'=>'complement', 'placeholder'=> trans('landlord.complement')]) !!}
                       </div>
                       @if ($errors->has('complement'))
                           <br/>
                           <span class="help-block">
                                        <strong>{{$errors->first('complement')}}</strong>
                                </span>
                       @endif
                   </div>

                   <div class="form-group {{$errors->has('zip') ? 'has-error' : ''}}">
                       {!! Form::label('zip', trans('landlord.zip').' :',
                                      ['class'=>'col-md-3 control-label', ]) !!}
                       <div class="col-sm-4">
                           {!! Form::text('zip', null,
                                 ['class'=>'form-control', 'id'=>'zip', 'placeholder'=> trans('landlord.zip')]) !!}
                       </div>
                       @if ($errors->has('zip'))
                           <br/>
                           <span class="help-block">
                                        <strong>{{$errors->first('zip')}}</strong>
                                </span>
                       @endif
                   </div>
                   <div class="form-group {{$errors->has('city') ? 'has-error' : ''}}">
                       {!! Form::label('city', trans('landlord.city').' :',
                                      ['class'=>'col-md-3 control-label', ]) !!}
                       <div class="col-sm-8">
                           {!! Form::select('city',[ 'default' => trans('landlord.city')] + $City, null,
                                ['class'=>'form-control', 'id'=>'city']) !!}
                       </div>
                       @if ($errors->has('city'))
                           <br/>
                           <span class="help-block">
                                        <strong>{{$errors->first('city')}}</strong>
                                </span>
                       @endif
                   </div>

                    <div class="form-group {{$errors->has('area') ? 'has-error' : ''}}" id="areaDiv" style="display: none">
                        {!! Form::label('area', trans('landlord.area').' :',
                                       ['class'=>'col-md-3 control-label', ]) !!}
                        <div class="col-sm-8">
                            {!! Form::select('area', [''=>''], null,
                                 ['class'=>'form-control', 'id'=>'area']) !!}
                        </div>
                        @if ($errors->has('area'))
                            <br/>
                            <span class="help-block">
                                        <strong>{{$errors->first('area')}}</strong>
                                </span>
                        @endif
                    </div>

                   <div class="form-group {{$errors->has('country') ? 'has-error' : ''}}">
                       {!! Form::label('country', trans('landlord.country').' :',
                                      ['class'=>'col-md-3 control-label', ]) !!}
                       <div class="col-sm-8">
                           {!! Form::text('country', null,
                                ['class'=>'form-control', 'id'=>'country', 'placeholder'=> trans('landlord.country')]) !!}
                       </div>
                       @if ($errors->has('country'))
                           <br/>
                           <span class="help-block">
                                        <strong>{{$errors->first('country')}}</strong>
                                </span>
                       @endif
                   </div>


                   <h3>Area</h3>

                   <div class="form-group {{$errors->has('wsarrond') ? 'has-error' : ''}}">
                       {!! Form::label('wsarrond', trans('landlord.wsarrond').' :',
                                      ['class'=>'col-md-3 control-label', ]) !!}
                       <div class="col-sm-8">
                           {!! Form::text('wsarrond', null,
                                ['class'=>'form-control', 'id'=>'country', 'placeholder'=> trans('landlord.wsarrond')]) !!}
                       </div>
                       @if ($errors->has('wsarrond'))
                           <br/>
                           <span class="help-block">
                                        <strong>{{$errors->first('wsarrond')}}</strong>
                                </span>
                       @endif
                   </div>
                   <div id="updated_map"></div>

                   <div class="form-group">
                       <div id="map" style="display: inline-flex"></div>
                       <i class="material-icons" onclick="fillInAddress()"
                          style="cursor: pointer;background-color: #9982bb; color: white;">cached</i>
                   </div>
                   <br/>
                   <button class="btn btn-default hover_viaflats form-control">Continue</button>
                   {!! Form::close() !!}
                </div> {{--Fin col md 8--}}


                <div class="col-md-3" id="recap_details">

                    <div class="needHelp">
                        <h3>@lang('landlord.needhelp')</h3>
                        <p>@lang('landlord.needHelpText')</p>
                        <span style="display:block;width: 100%; color: #9982bb">06 12 52 32 52</span>
                        <a href="#"> <span style="display:block;width: 100%; ">viaflats@hotmail.com</span></a>
                    </div>

                    <div class="recap">
                        <h3>@lang('landlord.details')</h3>
                        <div class="row">
                            {{-- <div class="col-md-3">
                                <i class="material-icons md-36" style="color: #9982bb;">domain</i>
                            </div> --}}
                            <div class="col-md-7" style="color : #717172; font-size:1.2em">
                                <div id="Recaptype"></div>
                                <span style="float:right; margin: auto;" id="Recapsize"></span>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-3">
                                <i class="material-icons md-inactive md-36" style="color: #9982bb;">lock_outline</i>
                            </div> --}}
                            <div class="col-md-7" style="color : #717172; font-size:1.2em">
                                <div id="Recaptype_room"></div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-3">
                                <i class="material-icons md-36" style="color: #9982bb;">map</i>
                            </div> --}}
                            <div class="col-md-7" style="color : #717172; font-size:1.2em">
                                <div id="Recapaddress"></div>
                            </div>
                        </div>

                    </div>
                </div> {{--Fin col md 3--}}

            </div> {{--Fin class Row--}}

        </div> {{--Fin col md 12--}}
    </div> {{--Fin class Row--}}

    <script>
        $('#detail_property input').on('change', function () {
            var value = $('input[name=type]:checked', '#detail_property').val();
            var value_room = $('input[name=room_type]:checked', '#detail_property').val();

            if (value == '2') {
                $('#radio_shared').attr('checked', false);
                $('#radio_entire').attr('checked', true);
                $('#radio_shared').attr('disabled', true);
            }
            else {
                $('#radio_shared').attr('disabled', false);
            }

            switch (value) {
                case '0':
                    var successContent = '<span>-{{trans('landlord.home')}} </span>';
                    $('#Recaptype').html(successContent);
                    break;
                case '1' :
                    var successContent = '<span>-{{trans('landlord.apartment')}} </span>';
                    $('#Recaptype').html(successContent);
                    break;
                case '2':
                    var successContent = '<span>-{{trans('landlord.studio')}} </span>';
                    $('#Recaptype').html(successContent);
                    break;
                default:
                    break;
            }

            switch (value_room) {
                case '1':
                    var successContent = '<span>-{{trans('landlord.shared')}}</span>';
                    $('#Recaptype_room').html(successContent);
                    break;
                case '0':
                    var successContent = '<span>-{{trans('landlord.entire')}}</span>';
                    $('#Recaptype_room').html(successContent);
                    break;
                default:
                    break;
            }
            if ($(this).attr('name') == 'Tsize') {
                var test = $('#Tsize').val();
                var size = '<span>' + test + ' m²</span>';
                $('#Recapsize').html(size);
            }



        });

        var wrap = $("#recap_details");

        $(window).scroll(function () {
            var $this = $(this);
            if ($this.scrollTop() > 250) {
                wrap.addClass('recap_fixed');
            } else {
                wrap.removeClass('recap_fixed');
            }
        });

        $('#city').on('change', function() {
            var val = $(this).val(); // on récupère la valeur de la city
            if(val != '' && val != 'default') {
                $('#area').empty(); // on vide la liste des départements

                $.ajax({
                    url: 'get_area',
                    data: 'idCity='+ val, // on envoie $_GET['id_region']
                    dataType: 'json',
                    success: function(json) {
                        $.each(json, function(index, value) {
                            $('#area').append('<option value="'+ index +'">'+ value +'</option>');
                        });
                    }
                });
                $('#areaDiv').show();


            }
            else if(val == 'default'){
                $('#area').empty();
                $('#areaDiv').hide();

            }
        });

    </script>



    <script>


        var marker, geocoder, map;

        function initialise() {

            var myCenter = new google.maps.LatLng(50.849447, 5.687979);
            geocoder = new google.maps.Geocoder();

            map = new google.maps.Map(document.getElementById('map'), {
                center: myCenter,
                scrollwheel: true,
                zoom: 10
            });

            $('#country').blur(function () {
                fillInAddress();
            });
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
//            House Number, Street Direction, Street Name, Street Suffix, City, State, Zip, Country
            var address = '';
            address = address + $('#streetNumber').val() + ',';
            address = address + $('#street').val() + ',';
            address = address + $('#complement').val() + ',';
            address = address + $('#city').find(":selected").text() + ',';
            address = address + $('#zip').val() + ',';
            address = address + $('#country').val();


            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var address = '<span>' + results[0].formatted_address + '</span>';

                    $('#Recapaddress').html(address);

                     placeMarker(results[0].geometry.location);

                    var content = "<div class='alert alert-success'><span>Map successfully update</span></div>";
                    $('#updated_map').html(content);
                    $('#updated_map').fadeOut(5000);
                    setTimeout(function () {
                        $('#updated_map').html('');
                    }, 4000);
                } else {
                    console.log('ok');
                    var content = "<div class='alert alert-danger'><span>Map cannot be updated, check all field</span></div>";
                    $('#updated_map').fadeIn();
                    $('#updated_map').html(content);
                    $('#updated_map').fadeOut(5000);

                }
            });

            google.maps.event.addListener(marker, 'click', function () {
                map.setZoom(15);
                map.setCenter(marker.getPosition());
            });

            function placeMarker(location) {
                if ( marker ) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });
                }
            }

        }


    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9S8pA48dV64YjrkD_SBnNLpMZwOv24wI&libraries=places&callback=initialise"
            async defer>

    </script>
@endsection