@extends('layouts.frontend', ['title' => 'Home'])

@section('content')
<section class="contact-from-section spad" id="booking">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Confirm Reservations</h2>
                    <p>Fill out the form below to complete reservations for event space.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if (count($errors))
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Error validating data.<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('suc_msg'))
                    <div class="alert alert-success" role="alert"><strong>Success!</strong> {{ session('suc_msg') }}</div>
                @endif
                @if (session('err_msg'))
                    <div class="alert alert-danger" role="alert"><strong>Oops!</strong> {{ session('err_msg') }}</div>
                @endif
                <form action="{{ route('booking.confirm') }}" method="POST" class="comment-form contact-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Your Name" required value="{{ old('name') }}">
                        </div>
                        <div class="col-lg-4">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Your Email" required value="{{ old('email') }}">
                        </div>
                        <div class="col-lg-4">
                            <label for="phone">Phone</label>
                            <input type="number" name="phone" id="phone" placeholder="Your Phone Number" required value="{{ old('phone') }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="event_center">Event Space</label>
                            <input type="text" name="event_center" id="event_center" value="{{ ucwords($space['title']) }}" readonly>
                            <input type="hidden" name="event_center_id" value="{{$availablity['event_center']}}">
                        </div>
                        <div class="col-lg-6">
                            <label for="event_center">Price</label>
                            <input type="number" name="price" id="price" value="{{ $space['price'] }}" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label for="event_date">Event Date</label>
                            <input type="text" name="event_date" id="event_date" value="{{ $availablity['event_date'] }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="guests">Expected Guests</label>
                            <input type="number" name="guests" id="guests" value="{{ old('guests') }}">
                        </div>
                        <div class="col-lg-12">
                            <label for="event_date">Terms and Condition</label>
                            <textarea placeholder="Messages"></textarea>
                            <div class="row">
                                <div class="col-auto">
                                    <input type="checkbox" name="agreement" id="agreement" required>
                                </div>
                                <div class="col">
                                    <span class="fs-4">I agree to the terms and condition above</span>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="site-btn">Pay ₦{{ number_format($space['price']) }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection