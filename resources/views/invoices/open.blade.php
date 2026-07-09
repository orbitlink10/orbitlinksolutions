<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice: {{ $invoice->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 2.2rem;
            color: #027333;
        }
        .status-container {
            text-align: right;
        }
        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .status-pending {
            background-color: #ffc107;
            color: #fff;
        }
        .status-paid {
            background-color: #28a745;
            color: #fff;
        }
        .status-overdue {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-pay-now {
            display: inline-block;
            margin-top: 5px;
            padding: 8px 15px;
            background-color: #027333;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-pay-now:hover {
            background-color: #025d28;
            transform: scale(1.05);
        }
        .details, .bill-to, .notes {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 2px solid #027333;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #027333;
            color: #fff;
            font-size: 14px;
        }
        table td {
            font-size: 14px;
            color: #555;
        }
        table tfoot th {
            font-size: 1.1rem;
            font-weight: bold;
            text-align: right;
        }
        table tfoot td {
            font-size: 1.1rem;
            font-weight: bold;
            text-align: right;
        }
        .notes p {
            font-size: 14px;
            color: #777;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            display: inline-block;
            padding: 10px 15px;
            font-size: 14px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back {
            background-color: #6c757d;
            margin-right: 10px;
        }
        .btn-download {
            background-color: #027333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice: {{ $invoice->name }}</h1>
            <div class="status-container">
                <span class="status status-{{ $invoice->status }}">
                    {{ ucfirst($invoice->status) }}
                </span>
                @if($invoice->status == 'pending') 
                    <a href="{{ route('pay_now_invoice', $invoice->id) }}" class="btn-pay-now">Pay Now</a>
                @endif
            </div>
        </div>

        <div class="details">
            <h2 class="section-title">Invoice Details</h2>
            <p><strong>Invoice No:</strong> {{ $invoice->id }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
            <p><strong>Issued Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
        </div>

        @if($client)
        <div class="bill-to">
            <h2 class="section-title">Billed To</h2>
            <p><strong>{{ $client->first_name ?? 'First Name' }} {{ $client->last_name ?? 'Last Name' }}</strong></p>
            <p>{{ $client->address ?? 'Address not provided' }}</p>
            <p>{{ $client->email ?? 'Email not provided' }}</p>
            <p>{{ $client->phone ?? 'Phone not provided' }}</p>
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-end">{{ $invoice->currency }} {{ number_format($item->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">No items found for this invoice.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total:</th>
                    <td class="text-end">
                        {{ $invoice->currency }} {{ number_format($invoice->items->reduce(function ($carry, $item) {
                            return $carry + $item->amount;
                        }, 0), 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="notes">
            <h2 class="section-title">Additional Notes</h2>
            <p>This invoice is issued for the services or products provided. Please make the payment before the due date to avoid penalties. For any inquiries, feel free to Call/WhatsApp us at <strong>{{ get_option('contact_phone') }}</strong>.</p>
            <p>Thank you for choosing our services!</p>
        </div>

        <div class="footer">

            <a href="{{ route('invoices.download', $invoice->id) }}" class="btn-download">Download Invoice</a>
        </div>
    </div>
</body>
</html>
