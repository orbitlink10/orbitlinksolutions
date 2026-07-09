<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body>
    <p>Dear Starlink Kenya Admin,</p>

    <p>I hope this message finds you well.</p>

    <p>We are pleased to inform you that a new order has been placed on our platform. Here are the details of the order and the customer:</p>

    <ul>
        <li>Customer Name: {{ $order->user->name }}</li>
        <li>Customer Email: {{ $order->user->email }}</li>
        <li>Customer Phone: {{ $order->user->phone }}</li>
        <li>Order ID: {{ $order->id }}</li>
        <li>Order Subtotal: {{ $order->subtotal }}</li>
        <li>Total Amount: {{ $order->total_amount }}</li>
        <li>Order Date: {{ $order->created_at->format('F d, Y H:i:s') }}</li>
    </ul>

    <p>Please review the order details at your earliest convenience and initiate the necessary fulfillment processes.</p>

    <p>Thank you for your attention to this new order.</p>

    <p>Best regards,<br>
    Starlink Kenya Team<br>
    <br>
    +254 729 299 439</p>
</body>
</html>

