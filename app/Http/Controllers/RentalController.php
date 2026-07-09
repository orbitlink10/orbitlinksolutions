<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;

class RentalController extends Controller
{
    /**
     * Display the rental form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rentals.create'); // Your view with the form
    }

    /**
     * Store a newly created rental in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'quantity' => 'required|integer|min:1',
            'damage_protection' => 'nullable|boolean',
            'wifi_router' => 'nullable|boolean',
        ]);

        // Create a new rental record
        Rental::create([
            'customer_name' => $request->customer_name,
            'phone_number' => $request->phone_number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quantity' => $request->quantity,
            'damage_protection' => $request->has('damage_protection') ? true : false,
            'wifi_router' => $request->has('wifi_router') ? true : false,
        ]);

   // Redirect to the thank you page
    return redirect()->route('rental.thank-you');
    }
}
