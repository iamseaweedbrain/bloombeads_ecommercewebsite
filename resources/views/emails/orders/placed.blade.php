<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #eee; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background-color: #FF6B81; padding: 20px; text-align: center; }
        .header h1 { color: white; font-family: 'Fredoka', sans-serif; margin: 0; }
        .content { padding: 30px; }
        .content p { color: #333; line-height: 1.6; }
        .order-summary { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .order-summary th, .order-summary td { border-bottom: 1px solid #eee; padding: 15px 0; text-align: left; }
        .total-row td { border-bottom: none; font-weight: bold; font-family: 'Fredoka', sans-serif; font-size: 1.2rem; }
        .footer { background-color: #F7F7F7; padding: 20px; text-align: center; color: #777; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You For Your Order!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $order->user->fullName }},</p>
            <p>Your order has been successfully placed. Your order tracking ID is <strong>#{{ $order->order_tracking_id }}</strong>. We will send you another email once your order has been shipped.</p>

            <h2 style="font-family: 'Fredoka', sans-serif; color: #333;">Order Summary</h2>
            <table class="order-summary">
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                            <td style="text-align: right;">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>Total (incl. shipping)</strong></td>
                        <td style="text-align: right; color: #FF6B81;">₱{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Bloombeads by Jinx. All Rights Reserved.
        </div>
    </div>
</body>
</html>