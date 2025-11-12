<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        .container { padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; max-width: 500px; margin: auto; }
        .button { display: inline-block; padding: 12px 20px; background-color: #FF6B81; color: white; text-decoration: none; font-weight: bold; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 style="font-family: 'Fredoka', sans-serif;">New Order Received!</h1>
            <p>A new order (<strong>#{{ $order->order_tracking_id }}</strong>) was just placed by {{ $order->user->fullName }}.</p>
            <p><strong>Total:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="text-align: center;">
                <a href="{{ route('admin.transactions.show', $order) }}" class="button">
                    View Order in Admin Panel
                </a>
            </p>
        </div>
    </div>
</body>
</html>