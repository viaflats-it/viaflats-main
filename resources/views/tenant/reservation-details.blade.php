@extends('layout.tenant')

@section('contenu')
    <div style="text-align:  center">
        <h1>@lang('tenant.reservation') #{{$booking->idBooking}} {{$estate->title}}</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4> @lang('tenant.booking_info')</h4>
            <img src="property/{{$estate->picture}}">
            <p>{{$estate->title}}</p>
            <p>{{$booking->checkin}} @lang('tenant.to') {{$booking->checkout}}</p>
            <p>@lang('tenant.guest') {{$booking->guest}}</p>
            <p class="details waiting">{{$booking->booking_fee}} @lang('tenant.to_paid')</p>
            <p class="details confirmed">@lang('tenant.invoice') {{$booking->idInvoice}}</p>
        </div>
        <div class="col-md-6">
            <!------- What is the next step ?  ------>
            <h4 class="details rejected waiting confirmed pending">@lang('tenant.what_next_step')</h4>
            <p class="details rejected">@lang('tenant.reject_step')</p>
            <p class="details rejected">@lang('tenant.reject_step_advice')</p>
            <p class="details waiting">@lang('tenant.waiting_step')</p>
            <p class="details confirmed">@lang('tenant.confirmed_step')</p>
            <p class="details confirmed">@lang('tenant.confirmed_step_advice')</p>
            <p class="details pending">@lang('tenant.pending_step')</p>
            <!------- Is the property still available ? ------>
            <h4 class="details waiting pending">@lang('tenant.is_available')</h4>
            <p class="details waiting pending">@lang('tenant.is_available_info')</p>

            <!------- I have received an invoice so I am renting the property, right ?  ------>
            <h4 class="details waiting">@lang('tenant.have_invoice')</h4>
            <p class="details waiting">@lang('tenant.have_invoice_info')</p>

            <!------- What will happen if I pay and the landlord doesn't accept me ?  ------>
            <h4 class="details waiting">@lang('tenant.landlord_not_accept')</h4>
            <li class="details waiting">@lang('tenant.landlord_not_accept_info')</li>
            <li class="details waiting">@lang('tenant.landlord_not_accept_info_second')</li>
            <li class="details waiting">@lang('tenant.landlord_not_accept_info_third')</li>

            <!------- Is the registration fee a one time payment or will I get it back after I left the place ?  ------>
            <h4 class="details waiting">@lang('tenant.registration_fee')</h4>
            <p class="details waiting">@lang('tenant.registration_fee_info')</p>

            <!------- Why is it written "Expired" on my reservation ?------>
            <h4 class="details waiting pending">@lang('tenant.why_expired')</h4>
            <p class="details waiting">@lang('tenant.why_expired_info_tenant')</p>
            <p class="details pending">@lang('tenant.why_expired_info_landlord')</p>

            <!------- What does the icons on the reservation details mean ?------>
            <h4 class="details waiting pending">@lang('tenant.what_icons')</h4>
            <p class="details waiting pending">@lang('tenant.delete_icon')</p>
            <p class="details confirmed">@lang('tenant.private_message_icon')</p>

            <!------- Why did the landlord reject my booking request ? ------>
            <h4 class="details rejected">@lang('tenant.why_reject_booking')</h4>
            <p class="details rejected">@lang('tenant.reject_booking_info')</p>
        </div>
    </div>
    <div class="row details waiting pending" style="text-align:center">
        <a href="DeleteReservation?ref={{$booking->idBooking}}">Delete Booking (Icon) </a>
    </div>

    <script>
        $(document).ready(function(){
            @if($booking->status == 'pending')
                $('.pending').show();
            @elseif($booking->status == 'waiting')
                $('.waiting').show();
            @elseif($booking->status == 'confirmed')
                $('.confirmed').show();
            @elseif($booking->status == 'rejected')
                $('.rejected').show();
            @endif
        });
    </script>
@endsection