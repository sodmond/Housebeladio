@component('mail::message')
# Dear {{ $fname }},

You have successfully completed the booking of our event center, see booking details below:

@component('mail::panel')
<strong>Name :</strong> {{ $bookingInfo->name }}

<strong>Phone :</strong> {{ $bookingInfo->phone }} 

<strong>Email :</strong> {{ $bookingInfo->email }} 

<strong>Guests :</strong> {{ $bookingInfo->guests }} 

<strong>Event Space :</strong> {{ $event_space }} 

<strong>Event Date :</strong> {{ $bookingInfo->event_date }} 

<strong>Reference :</strong> {{ $reference }} 
@endcomponent

<p>&nbsp;</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
