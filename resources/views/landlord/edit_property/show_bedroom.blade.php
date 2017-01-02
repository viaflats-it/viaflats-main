<div id='InfoBedroom'>
    <h4> @lang('landlord.'.($estate->furnished ? 'furnished' : 'unfurnished')) Bedroom </h4>
    <div class="row">
        <div class="col-md-5">
            <div class="infoBlock">
                <label>Size :</label>
                <span>{{$room->size}} m²</span> <br/>
                <label>Guest :</label>
                <span>{{$estate->guest_nb}}</span>
                <br/>
                <label>@if($estate->shared == 0)
                        Private
                    @elseif($estate->shared == 1)
                        Shared
                    @else
                        Couple
                    @endif
                </label>
                <br/>
                <label>{{$estate->rental_sub == 0 ? 'Rental sub unavailable' : 'Rental sub available'}}</label>
                <br/>
                <label>{{$estate->windows}} Windows</label>
                <br/>
                <label>{{$estate->street_side == 0 ? 'Not street Side' : 'Street side'}}</label>
            </div>
        </div>

        <div class="col-md-5">
            <div class="infoBlock">
                <label>Rent : </label>
                <span>{{$estate->rent}} €</span> <br/>
                @if(unserialize($estate->range_period)[0]['to'] != null)
                    <label>Rent Range : </label>  <br/>
                    @foreach(unserialize($estate->range_period) as $range)
                        <span>{{$range['from'] == 0 ? '' : '> ' . $range['from'] . ' Month'}}</span>
                        <span> < {{$range['to']}} Month </span>
                        <span>- Rent : {{$range['price']}} €</span> <br/>
                    @endforeach

                @endif

                @if($estate->booking_flexibility != 0)
                    <label>Booking Flexibility : </label>
                    <span>{{$estate->booking_flexibility}} Days</span>
                @endif

                @if($estate->mini_stay != 0)
                    <label>Minimum stay : </label>
                    <span>{{$estate->mini_stay}}</span>
                @endif

                @if($estate->checkin_preference != 0)
                    <label>Checkin Preference : </label>
                    <span>{{$estate->checkin_preference}}</span>
                @endif

                @if($estate->checkout_preference != 0)
                    <label>Checkout Preference : </label>
                    <span>{{$estate->checkin_preference}}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <label> Amenities </label>
            <br>
            @foreach($amenities as $amenity)
                <span>{{$amenity->label}}</span>
            @endforeach
        </div>

        <div class="col-md-2" id="bedroom{{$estate->idElement}}">
            <button type="button" id="infoEstate{{$estate->idElement}}"
                    class="btn form-control btn-default">
                Update
            </button>
            <button id="deleteEstate{{$estate->idElement}}" type="button"
                    class="btn btn-danger form-control"
                    style={{$estate->status != 1 ? '' : 'display:none'}}>Delete
            </button>
            <button id="ReactivateEstate{{$estate->idElement}}" type="button"
                    class="btn btn-info form-control"
                    style={{$estate->status == 1 ? '' : 'display:none'}}>Activate
            </button>
        </div>
    </div>
</div>

<script>

    $('[id^="infoEstate"]').on('click', function () {
        var idBedroom = $(this).attr('id').replace('infoEstate', '');
        $('#InfoBedroom').load('showEdit?bed=' + idBedroom);
    });

</script>

