<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF; 

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('items')->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'currency' => 'required|string|max:10',
    ]);

    // Generate the slug
    $slug = 'in-' . time() . '-' . Str::random(6);

    // Create the invoice with the generated slug
    $invoice = Invoice::create([
        'slug' => $slug,
        'name' => $request->input('name'),
        'currency' => $request->input('currency'),
    ]);

    if ($request->expectsJson()) {
        return response()->json(['id' => $invoice->id], 201);
    }

    return redirect()->route('invoice.items.create', $invoice->id)
        ->with('success', 'Invoice created successfully. Now add items to the invoice.');
}


    /**
     * Display the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, Invoice $invoice)
{
    // Validate the input fields
    $request->validate([
        'name' => 'required|string|max:255',
        'currency' => 'required|string|max:10',
        'due_date' => 'nullable|date', // Ensure due_date is a valid date or null
        'status' => 'required|string|in:pending,paid,overdue', // Validate status to be one of the allowed values
    ]);

    // Update the invoice with the validated data
    $invoice->update($request->only('slug', 'name', 'currency', 'due_date', 'status'));

    // Redirect with a success message
    return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
}


    /**
     * Remove the specified invoice from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }


        public function open($slug)
    {
        $invoice = Invoice::with('items')->where('slug', $slug)->firstOrFail();
         $client = $invoice->client;

        return view('invoices.open', compact('invoice', 'client'));
    }


        public function download($id)
    {
        // Fetch the invoice and related data
        $invoice = Invoice::with('items')->findOrFail($id);

        // Optionally include client details
        $client = $invoice->client;

        // Share data with the view
        $pdf = PDF::loadView('invoices.pdf', compact('invoice', 'client'));

        // Return the generated PDF for download
        return $pdf->download("invoice-{$invoice->slug}.pdf");
    }
}
