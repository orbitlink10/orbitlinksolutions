<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body>
    <p>Dear {{ username($order->user_id)->name }},</p>

    <p>I hope this message finds you well.</p>

    <p>We are pleased to confirm that your order has been received and is currently being processed. Below are the details of your order:</p>

    <ul>
        <li><strong>Order ID:</strong> {{ $order->id }}</li>
        <li><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</li>
        <li><strong>Subtotal:</strong> {{ number_format($order->subtotal, 2) }}</li>
        <li><strong>Total Amount:</strong> {{ number_format($order->total_amount, 2) }}</li>
        <!-- If there are specific products, you can list them here -->
        <li><strong>Product: {{product($order->product_id)->name ?? ""}}</strong>
            {{-- <ul>
                @foreach($order->products as $product)
                    <li>{{ $product->name }} - ${{ number_format($product->price, 2) }}</li>
                @endforeach
            </ul> --}}
        </li>
    </ul>

    <p>Thank you for your order. We will notify you once it has shipped.</p>

    <p>Best regards,<br>
    Starlink Kenya Team<br>
    <br>
    +254 729 299 439</p>
</body>
</html>

