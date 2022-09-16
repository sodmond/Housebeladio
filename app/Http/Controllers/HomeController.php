<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $event_centers = DB::table('event_centers')->get();
        return view('welcome', compact('event_centers'));
    }

    public function checkBooking(Request $request)
    {
        $this->validate($request, [
            'event_center' => 'required|integer',
            'event_date' => 'required|date|after:today',
        ]);
        $getBookings = Booking::where([
            ['event_center_id', $request->event_center],
            ['event_date', $request->event_date],
        ])->orWhere([
            ['event_center_id', 3],
            ['event_date', $request->event_date],
        ])->get();
        if ($request->event_center == 3) {
            $getBookings = Booking::where([
                ['event_center_id', 1],
                ['event_date', $request->event_date],
            ])->orWhere([
                ['event_center_id', 2],
                ['event_date', $request->event_date],
            ])->get();
        }
        if ($getBookings->count() < 1) {
            //dd($request->all());
            $availablity = $request->all();
            $space = DB::table('event_centers')->where('id', $request->event_center)->first();
            $expiry = time()+10800;
            setcookie('availablity', json_encode($availablity), $expiry);
            setcookie('space', json_encode($space), $expiry);
            //return view('reservation', compact('availablity', 'space'));
            return redirect()->route('booking'); //->withInput(['availablity' => $availablity, 'space' => $space]);
        }
        return back()->withErrors(['event_date_ops' => 'Event center not available for that day']);
    }

    public function booking(Request $request)
    {
        if ((! isset($_COOKIE['availablity'])) && (! isset($_COOKIE['availablity']))) {
            return redirect('/');
        }
        $availablity = json_decode($_COOKIE['availablity'], true);
        $space = json_decode($_COOKIE['space'], true);
        //dd($space);
        return view('reservation', compact('availablity', 'space'));
    }

    public function adminHome()
    {
        $bookings_total = Booking::count();
        $bookings_today = Booking::whereRaw('DATE(created_at) = CURDATE()')->count();
        $bookings_yesterday = Booking::whereRaw('DATE(created_at) = SUBDATE(CURDATE(),1)')->count();
        $payments_count = DB::table('transactions')->count();
        $payments_total = DB::table('transactions')->sum('amount');
        $payments_today = DB::table('transactions')->whereRaw('DATE(created_at) = CURDATE()')->sum('amount');
        return view('admin.home', [
            'bookings_total' => $bookings_total, 
            'bookings_today' => $bookings_today,
            'bookings_yesterday' => $bookings_yesterday,
            'payments_count' => $payments_count,
            'payments_total' => $payments_total,
            'payments_today' => $payments_today,
        ]);
    }

    public function admin()
    {
        return redirect()->route('admin.dashboard');
    }
}
