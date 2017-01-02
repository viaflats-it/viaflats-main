<div id="infoRoom">
    @foreach($rooms as $room)
        <div class="col-md-12">
            <div class="row">
                <h4>{{$title}} {{$room->idRoom}}</h4>
            </div>
            <div class="col-md-6">
                <label> Size : </label>
                <span> {{$room->size}}</span>
                <label> Amenities : </label>
                @foreach($amenities[$room->idRoom] as $amenity)
                    <span>{{$amenity->label}}</span>
                @endforeach
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" id="room{{$room->idRoom}}"
                    class="btn form-control btn-default">
                Update
            </button>
        </div>
    @endforeach
</div>

<script>
    $('[id^="room"]').on('click', function () {
        var idRoom = $(this).attr('id').replace('room', '');
        $('#infoRoom').load('showEditRoom?room=' + idRoom);
    });
</script>
