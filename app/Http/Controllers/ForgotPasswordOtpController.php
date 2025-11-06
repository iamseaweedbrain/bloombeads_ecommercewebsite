<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\OtpReset; 
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException; // Re-introduced to handle standard validation failures

class ForgotPasswordOtpController extends Controller
{
    protected $otpTtlMinutes = 10;
    protected $maxAttempts = 5;
    protected $tokenMaxAgeHours = 1;

    public function requestOtp(Request $request)
    {
        // Handle validation errors via standard Laravel exception handling (which returns a 422 JSON response)
        try {
            $validated = $request->validate(['email' => 'required|email']);
        } catch (ValidationException $e) {
            // Re-throw to let Laravel handle the 422 response with detailed errors
            throw $e;
        }
        
        $user = User::where('email', $validated['email'])->first();
        
        // SECURITY FIX: Always return 200 success, regardless of user existence, to prevent email enumeration.
        if ($user) {
            $otp = random_int(100000, 999999);
            $otpHash = Hash::make($otp);
            $expiresAt = Carbon::now()->addMinutes($this->otpTtlMinutes);

            OtpReset::where('email', $validated['email'])->delete();

            OtpReset::create([
                'email' => $validated['email'],
                'otp_hash' => $otpHash,
                'expires_at' => $expiresAt,
            ]);

            try {
                Mail::to($validated['email'])->send(new OtpMail($otp, $this->otpTtlMinutes));
            } catch (\Throwable $e) {
                Log::error('OTP Mail failed to send: ' . $e->getMessage());
                // Continue execution to return generic success message
            }
        }

        // Standardized Success Response (HTTP 200)
        return response()->json(['message' => 'If that email exists, a reset code has been sent.'], 200);
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            throw $e;
        }

        $record = OtpReset::where('email', $request->email)->first();

        if (! $record) {
            return response()->json(['message' => 'Invalid or expired code. Please try again.'], 422);
        }

        if ($record->attempts >= $this->maxAttempts) {
            $record->delete();
            return response()->json(['message' => 'Too many attempts. Please request a new code.'], 422);
        }

        if (Carbon::now()->gt($record->expires_at)) {
            $record->delete();
            return response()->json(['message' => 'Code expired. Please request a new one.'], 422);
        }
        
        // **CRITICAL FIX 1: Trim the user input**
        $userInputOtp = trim($request->otp);

        // **CRITICAL FIX 2: Use Hash::check with the trimmed input**
        $isValid = Hash::check($userInputOtp, $record->otp_hash);

        if (! $isValid) {
            $record->increment('attempts');
            return response()->json(['message' => 'Invalid code.'], 422);
        }

        // OTP is valid
        $payload = [
            'email' => $record->email,
            'iat' => time(),
        ];
        $resetToken = encrypt($payload);

        $record->delete(); 

        return response()->json([
            'message' => 'Code verified.',
            'reset_token' => $resetToken
        ], 200);
    }
    
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'reset_token' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);
        } catch (ValidationException $e) {
            throw $e;
        }

        try {
            $payload = decrypt($request->reset_token);
        } catch (\Throwable $e) {
            // Standardized Error Response (HTTP 422)
            return response()->json(['message' => 'Invalid or expired reset token.'], 422);
        }

        $email = $payload['email'] ?? null;
        $iat = $payload['iat'] ?? 0;

        // Check token age
        if (time() - $iat > $this->tokenMaxAgeHours * 3600) {
            // Standardized Error Response (HTTP 422)
            return response()->json(['message' => 'The reset link has expired. Please restart the process.'], 422);
        }

        if (! $email) {
            // Standardized Error Response (HTTP 422)
            return response()->json(['message' => 'Invalid token payload.'], 422);
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            // User not found (shouldn't happen if verification passed, but good safeguard)
            // Standardized Error Response (HTTP 422)
            return response()->json(['message' => 'User not found.'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Standardized Success Response (HTTP 200)
        return response()->json(['message' => 'Password reset successful. You can now log in.']);
    }
}