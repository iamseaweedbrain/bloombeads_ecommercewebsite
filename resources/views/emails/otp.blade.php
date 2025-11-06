@component('mail::message')
# Your OTP Code

Your one-time password is:

**{{ $otp }}**

It expires in **{{ $ttl }} minutes**.

If you didn’t request this, just ignore this email.

Thanks,  
{{ config('app.name') }}
@endcomponent
