<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
    <style>
        /* Import the fonts directly in the style tag */
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@600&family=Poppins:wght@400;700&display=swap');
        
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: #F7F7F7; }
        .container { width: 90%; max-width: 600px; margin: 20px auto; border: 1px solid #eee; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background-color: #FF6B81; padding: 20px; text-align: center; } /* Using Sakura for the header */
        .header h1 { color: white; font-family: 'Fredoka', sans-serif; margin: 0; font-size: 28px; }
        .content { padding: 30px; }
        .content p { color: #333; line-height: 1.6; font-size: 16px; margin-bottom: 20px; }
        .otp-box { background-color: #F7F7F7; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; border: 1px dashed #FF6B81; }
        .otp-box .label { font-size: 14px; color: #777; margin: 0; }
        .otp-box .code { font-family: monospace; font-size: 36px; font-weight: bold; color: #333; letter-spacing: 10px; margin: 10px 0; }
        .footer { background-color: #F7F7F7; padding: 20px; text-align: center; color: #777; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Code</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>We received a request to reset the password for your account. Please use the One-Time Password (OTP) below to complete the verification process.</p>

            <div class="otp-box">
                <p class="label">Your One-Time Password is:</p>
                <p class="code">{{ $otp }}</p>
            </div>

            <p style="font-weight: 600; color: #FF6B81;">
                Important: This code is valid for <strong>{{ $ttl }} minutes</strong> only. Do not share this code with anyone.
            </p>
            
            <p style="font-size: 14px; color: #6b7280;"> 
                Security Alert: If you did not request a password reset, please ignore this email immediately. Your password will remain secure and unchanged.
            </p>

            <p>Thanks,<br>The {{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>