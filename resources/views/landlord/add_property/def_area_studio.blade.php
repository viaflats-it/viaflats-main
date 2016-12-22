@extends('layout.landlord')

@section('content')

    <div class="row ">
        <div class="col-md-12">
            <h3>Studio</h3>
            <h4> @lang('landlord.size')  {{$property->size}} m²</h4>
            <div class="row">
                <div class="col-md-8">
                    {{$errors->first()}}
                    {!! Form::open(['url'=>'definition_area']) !!}

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
                $('#number-'+this.value).show();
            }
            else {
                $('#number-'+this.value).val(0);
                $('#number-'+this.value).hide();
            }

        });

        $('label').click(function(e) {
            e.preventDefault();
            var idInput = $('#'+$(this).attr('for'));
            console.log(idInput.val());
            if( idInput.prop('checked') == true)
            {
                idInput.prop('checked', false);
                $('#number-'+idInput.val()).val(0);
                $('#number-'+idInput.val()).hide();

            }
            else {
                idInput.prop('checked', true);
                $('#number-'+idInput.val()).val(1);
                $('#number-'+idInput.val()).show();
            }
        });
    </script>

@endsection