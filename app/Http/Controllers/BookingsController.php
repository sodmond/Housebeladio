<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Unicodeveloper\Paystack\Facades\Paystack;

class BookingsController extends Controller
{
    public function index($search = "")
    {
        if ($search != "") {
            $bookings = Booking::where('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")->orderByDesc('created_at')->paginate(15);
            return view('admin.bookings', compact('bookings', 'search'));
        }
        $bookings = Booking::orderByDesc('created_at')->paginate(15);
        return view('admin.bookings', compact('bookings'));
    }

    public function view($id)
    {
        $booking = Booking::find($id);
        $payment = DB::table('transactions')->where('booking_id', $booking->id)->first();
        return view('admin.bookings_view', compact('booking', 'payment'));
    }

    public function booking(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|numeric',
            'event_center_id' => 'required|integer',
            'price' => 'required|numeric',
            'event_date' => 'required|date',
            'guests' => 'required|numeric',
        ]);
        $event_center = DB::table('event_centers')->where('id', $request->event_center_id)->first();
        if ($request->guests > $event_center->capacity) {
            $msg = 'Expected Guests cannot be greater than the event capacity' . $event_center->capacity;
            return back()->with('err_msg', $msg);
        }
        $meta = $request->all();
        $data = [
            'amount'    => ($request->price * 100),
            'email'     => $request->email,
            'currency'  => 'NGN',
            'reference' => Paystack::genTranxRef(),
            'metadata'      => $meta,
        ];
        $pay = new PaymentController;
        return $pay->redirectToGateway($data);
    }

    public function search()
    {
        if (isset($_GET['search'])) {
            return redirect()->route('admin.bookings.search.result', ['search' => $_GET['search']]);
        }
        return redirect('/');
    }
}
