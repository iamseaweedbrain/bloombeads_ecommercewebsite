<x-format>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@600&family=Poppins:wght@400;700&display=swap');
    </style>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #F7F7F7; font-family: 'Poppins', sans-serif; line-height: 1.5;">
        <tr>
            <td align="center" style="padding: 25px 0;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);">
                    
                    <tr>
                        <td align="center" style="padding: 30px 20px 20px 20px;">
                            <h1 style="font-family: 'Fredoka', sans-serif; font-size: 32px; color: #333333; margin: 0;">
                                {{ config('app.name') }}
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 40px 20px 40px; font: ; color: #333333; font-size: 16px;">
                            <h2 style="font-size: 24px; font-weight: bold; color: #FF6B81; margin: 0 0 15px 0;">
                                Password Reset Code
                            </h2>
                            <p style="margin-bottom: 20px;">
                                Hello,
                            </p>
                            <p style="margin-bottom: 20px;">
                                We received a request to reset the password for your account. Please use the **One-Time Password (OTP)** below to complete the verification process.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #F7F7F7; border-radius: 8px; margin-bottom: 25px; border: 1px dashed #FF6B81;">
                                <tr>
                                    <td align="center" style="padding: 20px;">
                                        <div style="font-family: monospace; font-size: 36px; font-weight: bold; letter-spacing: 10px; color: #333333; padding: 5px 0;">
                                            {{ $otp }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-bottom: 20px; font-weight: 600; color: #FF6B81;">
                                Important: This code is valid for <strong>{{ $ttl }} minutes</strong> only. Do not share this code with anyone.
                            </p>
                            
                            <!-- Action Button 
                            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 30px; margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <table cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="border-radius: 8px; background-color: #FFB347; padding: 12px 25px; text-align: center;">
                                                    <a href="{{ route ('verifyOtp') }}" target="_blank" style="color: #ffffff; text-decoration: none; font-weight: bold; font-size: 16px; font-family: 'Poppins', sans-serif; display: inline-block;">
                                                        Continue Password Reset
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        -->
                            <p style="margin-bottom: 20px; font-size: 14px; color: #6b7280;">   
                                Security Alert: If you did not request a password reset, please ignore this email immediately. Your password will remain secure and unchanged.
                            </p>
                            <p style="margin-top: 30px;">
                                Thanks,
                                <br>
                                The {{ config('app.name') }} Team
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 20px 40px; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</x-format>