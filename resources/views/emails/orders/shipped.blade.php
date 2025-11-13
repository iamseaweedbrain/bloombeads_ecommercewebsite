<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Shipped</title>
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #eee; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background-color: #FF6B81; padding: 20px; text-align: center; }
        .header h1 { color: white; font-family: 'Fredoka', sans-serif; margin: 0; }
        .content { padding: 30px; }
        .content p { color: #333; line-height: 1.6; }
        .tracking-info { background-color: #F7F7F7; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
        .tracking-info .label { font-size: 14px; color: #777; }
        .tracking-info .code { font-size: 20px; font-weight: bold; color: #333; letter-spacing: 1px; margin: 5px 0; }
        .button { display: inline-block; padding: 12px 25px; background-color: #FF6B81; color: white; text-decoration: none; font-family: 'Fredoka', sans-serif; font-weight: bold; border-radius: 8px; }
        .footer { background-color: #F7F7F7; padding: 20px; text-align: center; color: #777; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Order is on its Way!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $order->user->fullName }},</p>
            <p>Good news! Your Bloombeads order (<strong>#{{ $order->order_tracking_id }}</strong>) has been shipped and is now on its way to you.</p>

            <div class="tracking-info">
                <p class="label">You can track your package with this ID:</p>
                <p class="code">J&T-{{ $order->order_tracking_id }}</p>
                <p class="label" style="margin-top: 15px;">(Note: This is a placeholder. We will add a real tracking link here later.)</p>
            </div>

            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ route('order.show', $order->order_tracking_id) }}" class="button">View Your Order</a>
            </p>

            <p>Thank you for shopping with us!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Bloombeads by Jinx. All Rights Reserved.
        </div>
    </div>
</body>
</html>