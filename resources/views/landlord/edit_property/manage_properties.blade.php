@extends('layout.landlord')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <h4>{{$title}}</h4>
        </div>

        <div class="col-md-12">
            @foreach($bedroom as $room)
                <button id="room{{$room->idRoom}}"
                        class="typeof type{{$room->idTypeRoom}}">{{$roomLabel[$room->idRoom]}}</button>
            @endforeach
            @foreach($otherLabel as $label)
                    <button class="typeof type{{$label->idTypeRoom}}">{{$label->label}}</button>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="info">
        </div>
    </div>

    <script>

        $(".typeof").on('click', function () {
            var type = $(this).attr('class').replace('typeof type', '');
            $('#info').html('');

            switch (type) {
                case '1' :
                    $("#info").load('showInfoRoom?id='+'{{$property->idProperty}}'+'&type=1');
                    break;
                case '2':
                    $("#info").load('showInfoRoom?id='+'{{$property->idProperty}}'+'&type=2');
                    break;
                case '3':
                    var id = $(this).attr('id').replace('room', '');
                    bedroom(id, '{{$property->idProperty}}');
                    break;
                case '4':
                    $("#info").load('showInfoRoom?id='+'{{$property->idProperty}}'+'&type=4');
                    break;
                case '5':
                    $("#info").load('showInfoRoom?id='+'{{$property->idProperty}}'+'&type=5');
                    break;
                case '6':
                    $("#info").load('showInfoRoom?id='+'{{$property->idProperty}}'+'&type=6');
                    break;
                case '8':
                    $("#info").load('showInfoRoom?id='+'{{$property->idProperty}}'+'&type=8');
                    break;
            }
        });

        function bedroom(idBedroom, idProperty) {
            $('#info').load('showInfoBedroom?room=' + idBedroom);
        }


    </script>
@endsection