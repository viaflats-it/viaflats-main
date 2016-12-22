@extends('layout.landlord')

@section('content')

    <div class="row ">
        <div class="col-md-12">
            <h3>@lang('landlord.'.$typeRoom->label)  </h3>
            <h4> @lang('landlord.size')  {{$room->size}} m²</h4>
            <div class="row">
                <div class="col-md-8">
                    {{$errors->first()}}
                    {!! Form::open(['url'=>'definition_area']) !!}
                    {!! Form::hidden('numb' , $numb) !!}
                    {!! Form::hidden('room' , $room->idRoom) !!}

                @foreach($amenities as $amenity)
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::checkbox('amenities[]', $amenity->idAmenity, null,
                                        ['class' => 'checkbox col-md-2' , 'id' => 'amenity-'.$amenity->idAmenity]) !!}
                                {!! Form::label('amenity-'.$amenity->idAmenity, trans('landlord.'.$amenity->label) ) !!}
                                {!! Form::number('number['.$amenity->idAmenity.']' , 0 ,
                                        ['class' => 'form-control' , 'id'=>'number-'.$amenity->idAmenity]) !!}
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12">
                    {!! Form::submit('continue', ['class' => 'btn btn-default hover_viaflats form-control']) !!}
                    {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script>
       $(".checkbox").change(function() {
           if (this.checked){
               $('#number-'+this.value).val(1);
           }
           else {
               $('#number-'+this.value).val(0);
           }

       });

    </script>

@endsection