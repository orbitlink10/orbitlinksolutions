<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice: {{ $invoice->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #027333;
        }
        .header p {
            margin: 5px 0;
            color: #555;
        }
        .status {
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
        }
        .status-pending {
            background-color: #ffc107; /* Yellow */
        }
        .status-paid {
            background-color: #28a745; /* Green */
        }
        .status-overdue {
            background-color: #dc3545; /* Red */
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 2px solid #027333;
            padding-bottom: 5px;
        }
        .details, .bill-to {
            margin-bottom: 20px;
        }
        .details p, .bill-to p {
            margin: 5px 0;
            color: #555;
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
        .total-row th {
            font-weight: bold;
            text-align: right;
            font-size: 16px;
            border: none;
        }
        .total-row td {
            font-weight: bold;
            font-size: 16px;
            border: none;
            text-align: left;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #027333;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $invoice->name }} Invoice</h1>
            <p><strong>Invoice No:</strong> {{ $invoice->id }}</p>
            @if($invoice->due_date)
                <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
            @endif
            <p>
                <strong>Status:</strong>
                <span class="status status-{{ $invoice->status }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </p>
        </div>

        @if($client)
            <div class="bill-to">
                <h2 class="section-title">Billed To:</h2>
                <p><strong>{{ $client->first_name ?? '' }} {{ $client->last_name ?? '' }}</strong></p>
                <p>{{ $client->address ?? 'Address not provided' }}</p>
                <p>{{ $client->email ?? 'Email not provided' }}</p>
                <p>{{ $client->phone ?? 'Phone not provided' }}</p>
            </div>
        @endif

        <div class="details">
            <h2 class="section-title">Invoice Details:</h2>
            <p>This invoice has been issued for the services or products provided. Kindly settle the payment by the due date mentioned above. For any inquiries regarding this invoice, please contact us using the details below.</p>
        </div>

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
                        <td colspan="3" class="text-center">No items found for this invoice.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <th colspan="2">Total:</th>
                    <td class="text-end">{{ $invoice->currency }} {{ number_format($invoice->items->reduce(function ($carry, $item) { return $carry + $item->amount; }, 0), 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>If you have any questions about this invoice, please Call/WhatsApp us at <a href="mailto:{{ get_option('contact_email') }}">{{ get_option('contact_phone') }}</a>.</p>
            <p>Visit our website: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
        </div>
    </div>
</body>
</html>
