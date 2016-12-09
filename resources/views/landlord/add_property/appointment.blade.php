@extends('layout.landlord')

@section('content')

    <div class="row ">
        <div class="col-md-12">
            <h3>Appointment with a Photographer</h3>
            <div class="row">
                <div class="col-md-8">
                    {!! Form::open(['url' => 'truc']) !!}

                    {!! Form::select('date',  $date, null, ['class' => 'form-control size50']) !!}

                </div>
            </div>
        </div>
    </div>


@endsection