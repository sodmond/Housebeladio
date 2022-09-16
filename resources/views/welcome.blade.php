@extends('layouts.frontend', ['title' => 'Home'])

@section('content')
<!-- Hero Section Begin -->
<section class="hero-section set-bg" data-setbg="img/hero1.jpg" id="home">
    <div class="container">
        <div class="row" style="padding-bottom:100px;">
            <div class="col-lg-7">
                <div class="hero-text">
                    <span>House Beladio, Full Service Event Venue</span>
                    <h2>Make A Reservation<br /> For Your Event</h2>
                    <a href="#booking" class="primary-btn">Book Now</a>
                </div>
            </div>
            <div class="col-lg-5">
                {{--<img src="img/hero-right.png" alt="">--}}
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<section class="contact-from-section spad" id="booking">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Booking Form</h2>
                        <p>Fill out the form below to check availability of an event space.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if (count($errors))
                        <div class="alert alert-danger mb-2">
                            <strong>Whoops!</strong> Error validating data.<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success" role="alert"><strong>Success!</strong> {{ session('suc_msg') }}</div>
                    @endif
                    <form action="{{ route('booking.check') }}" class="comment-form contact-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="event_center">Choose Event Center Space</label>
                                <select name="event_center" id="event_center" required>
                                    <option value="">- - - Select Event Space - - -</option>
                                    @foreach ($event_centers as $space)
                                        <option value="{{$space->id}}">{{ ucwords($space->title) .' @ ₦'. number_format($space->price) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <?php 
                                $today = date('Y-m-d');
                                $tomorrow = date('Y-m-d', strtotime($today . ' +1 day'))
                                ?>
                                <label for="event_date">Select Event Date</label>
                                <input type="date" name="event_date" id="event_date" min="{{ $tomorrow }}" placeholder="mm/dd/yyyy" required>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="site-btn">Check Availability</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@push('custom-script')
    <script>
        $(document).ready(function() {
            var event_date = $('#event_date');
            if (event_date.attr('type') != 'date') { 
                //alert('Worked!');
                event_date.datepicker({
                    minDate: +1,
                });
            }
            //$('input[type=date]').on('load', function(){ alert('Worked!') });
        });
    </script>
@endpush
@endsection