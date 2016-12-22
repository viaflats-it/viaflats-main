@extends('layout.landlord')

@section('content')

    @foreach($properties as $property)
        <div class="row">
            <div class="col-md-2">
                <img src="img/{{$picture[$property->idProperty]}} " width="100" height="...">
            </div>
            <div class="col-md-4">
                City :
                {{$prop_city[$property->idProperty]}}
                <br>
                Title :
                {{$title[$property->idProperty]}}
                <br>
                Area :
                {{$prop_area[$property->idProperty]}}
                <br>
                Number of Estate :
                {{$nbEstate[$property->idProperty]}}
                <br>
                <br>
            </div>
        </div>
        <br>
        <div>
            <button> Edit Property  </button>
            <button id="#{{$property->idProperty}}" class="manageTenant"> Manage My Tenant </button>
        </div>
        <br>
    @endforeach

    <script>

        $(".manageTenant").on('click',function () {
            var id = $(this).attr('id').replace('#', '');
            window.open("manageTenant?ref=" + id);
        })

    </script>

@endsection