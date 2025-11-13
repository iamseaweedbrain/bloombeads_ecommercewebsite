<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Password Reset Code</title>
    <!-- We'll try to import the fonts, but email client support varies -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Fredoka:wght@500;700&display=swap" rel="stylesheet">
    <style>
        /* Base styles */
        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #fdfdfd;
        }
        
        .container { 
            width: 90%; 
            max-width: 600px; 
            margin: 20px auto; 
            border: 1px solid #eee; 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
        }
        
        /* Header */
        .header { 
            background-color: #FF6B81; 
            padding: 25px 20px; 
            text-align: center; 
        }
        
        .header h1 { 
            color: white; 
            font-family: 'Fredoka', sans-serif; 
            margin: 0;
            font-size: 1.8rem;
        }
        
        /* Content */
        .content { 
            padding: 30px 35px; 
        }
        
        .content p { 
            color: #333; 
            line-height: 1.6; 
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .content p.intro {
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        /* OTP Box */
        .otp-box {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            margin: 30px 0;
            border: 1px dashed #FF6B81;
        }
        
        .otp-box p {
            margin: 0 0 10px 0;
            font-size: 1rem;
            color: #555;
        }

        .otp-code {
            font-family: 'Fredoka', sans-serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: #FF6B81;
            letter-spacing: 5px;
            margin: 0;
        }
        
        .warning {
            font-size: 0.9rem;
            color: #777;
        }

        /* Footer */
        .footer { 
            background-color: #F7F7F7; 
            padding: 25px; 
            text-align: center; 
            color: #777; 
            font-size: 12px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <!-- Use a fallback 'there' if $name is not provided -->
            <p class="intro">Hi {{ $name ?? 'there' }},</p>
            
            <p>We received a request to reset the password for your account. Please use the One-Time Password (OTP) below to proceed.</p>

            <div class="otp-box">
                <p>Your OTP Code is:</p>
                <!-- $otp is the variable you should pass from your controller -->
                <h2 class="otp-code">{{ $otp }}</h2>
            </div>

            <p>This code is valid for 10 minutes. For your security, do not share this code with anyone.</p>
            
            <p class="warning">If you did not request a password reset, please ignore this email. Your account is still secure.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Bloombeads by Jinx. All Rights Reserved.
        </div>
    </div>
</body>
</html>