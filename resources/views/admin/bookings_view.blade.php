@extends('layouts.admin', ['title' => 'Bookings', 'activePage' => 'bookings'])

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Booking</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Booking Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $booking->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Event Space</th>
                                        <td><?php
                                            $e = new \App\Models\Booking;
                                            $spaceName = $e->getEventSpaceName($booking->event_center_id);
                                            echo $spaceName;
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <th>Event Date</th>
                                        <td>{{ $booking->event_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Renter Name</th>
                                        <td>{{ $booking->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $booking->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Expected Guests</th>
                                        <td>{{ $booking->guests }}</td>
                                    </tr>
                                    <tr>
                                        <th>Booking Date</th>
                                        <td>{{ $booking->created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="h5">Payment</p>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Amount</th>
                                        <td>₦{{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Reference</th>
                                        <td>{{ $payment->reference }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $payment->status }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
