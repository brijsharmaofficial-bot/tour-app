<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthOtpController extends Controller
{
    protected $msg91AuthKey;
    protected $msg91TemplateId;
    protected $otpExpiryMinutes;

    public function __construct()
    {
        $this->msg91AuthKey = env('MSG91_AUTH_KEY');
        $this->msg91TemplateId = env('MSG91_TEMPLATE_ID');
        $this->otpExpiryMinutes = (int) env('MSG91_OTP_EXPIRY_MINUTES', 5);
    }

    // ------------------------
    // SEND OTP
    // ------------------------
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $phone = $this->formatPhone($request->phone);
        $otp = random_int(100000, 999999);

        Cache::put("otp:$phone", $otp, now()->addMinutes($this->otpExpiryMinutes));

        $payload = [
            "mobile" => $phone,
            "template_id" => $this->msg91TemplateId,
            "otp" => "$otp"
        ];

        try {
            $response = Http::withHeaders([
                "authkey" => $this->msg91AuthKey,
                "Content-Type" => "application/json"
            ])->post("https://control.msg91.com/api/v5/otp", $payload);

            Log::info("MSG91 sendOtp", [
                "status" => $response->status(),
                "body" => $response->body()
            ]);

            if ($response->successful()) {
                return response()->json([
                    "success" => true,
                    "message" => "OTP sent",
                    "otp" => $otp
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "MSG91 Error",
                "details" => $response->json()
            ], 500);

        } catch (\Throwable $e) {

            Log::error("MSG91 Exception", [
                "error" => $e->getMessage()
            ]);

            return response()->json([
                "success" => false,
                "message" => "Server error",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    // ------------------------
    // VERIFY OTP
    // ------------------------
    public function verifyOtp(Request $request)
    {
        $request->validate([
            "phone" => "required|string",
            "otp" => "required|string"
        ]);

        $phone = $this->formatPhone($request->phone);
        $enteredOtp = $request->otp;

        $storedOtp = Cache::get("otp:$phone");

        if (!$storedOtp) {
            return response()->json([
                "success" => false,
                "message" => "OTP expired or not found"
            ], 400);
        }

        if ($storedOtp != $enteredOtp) {
            return response()->json([
                "success" => false,
                "message" => "Invalid OTP"
            ], 400);
        }

        Cache::forget("otp:$phone");

        // Create/Update user
        $user = User::updateOrCreate(
            ['phone' => $phone],
            ['phone' => $phone]
        );

        return response()->json([
            "success" => true,
            "message" => "OTP verified",
            "user" => $user
        ]);
    }

    // ------------------------
    // RESEND OTP
    // ------------------------
    public function resendOtp(Request $request)
    {
        $request->validate([
            "phone" => "required|string"
        ]);

        $phone = $this->formatPhone($request->phone);

        // Prevent spam resend
        if (Cache::has("otp-resend:$phone")) {
            return response()->json([
                "success" => false,
                "message" => "Please wait before resending OTP"
            ], 429);
        }

        $otp = random_int(100000, 999999);

        Cache::put("otp:$phone", $otp, now()->addMinutes($this->otpExpiryMinutes));
        Cache::put("otp-resend:$phone", true, now()->addSeconds(60));

        $payload = [
            "mobile" => $phone,
            "retrytype" => "text"
        ];

        try {
            $response = Http::withHeaders([
                "authkey" => $this->msg91AuthKey,
                "Content-Type" => "application/json"
            ])->post("https://control.msg91.com/api/v5/otp/retry", $payload);

            Log::info("MSG91 resendOtp", [
                "status" => $response->status(),
                "body" => $response->body()
            ]);

            if ($response->successful()) {
                return response()->json([
                    "success" => true,
                    "message" => "OTP resent",
                    "otp" => app()->environment('production') ? null : $otp
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Failed to resend OTP",
                "details" => $response->json()
            ], 500);

        } catch (\Throwable $e) {

            Log::error("MSG91 resend exception", [
                "error" => $e->getMessage()
            ]);

            return response()->json([
                "success" => false,
                "message" => "Server error",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    private function formatPhone($phone)
    {
        $clean = preg_replace('/\D+/', '', $phone);

        if (strlen($clean) === 10) {
            return "91" . $clean;
        }

        return $clean;
    }
}
