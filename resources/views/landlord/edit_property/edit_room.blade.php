<div class="row">
    <br>
    {!! Form::open(['url'=>'update_room']) !!}
    <div class="col-md-4">
        {!! Form::label('Size') !!}
        {!! Form::number('room_size') !!}
    </div>
    <div class="col-md-6">
        @foreach($amenities as $amenity)
            {!! Form::label($amenity->label) !!}
            {!! Form::radio('test' ) !!}
        @endforeach
    </div>
    {!! Form::submit('Save') !!}
    {!! Form::close() !!}
</div>