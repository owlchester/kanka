<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Jobs\Users\DeleteUser;
use App\Models\JobLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeletionController extends Controller
{
    public function handle(Request $request)
    {
        $signedRequest = $request->input('signed_request');
        if (!$signedRequest) {
            return response()->json(['error' => 'missing signed_request'], 400);
        }

        $data = $this->parseSignedRequest($signedRequest, config('services.facebook.client_secret'));
        if (!$data || !isset($data['user_id'])) {
            return response()->json(['error' => 'invalid signed_request'], 400);
        }

        $userId = $data['user_id'];
        $confirmation = 'fbdel_' . $userId . '_' . time();

        $user = User::where(['provider' => 'facebook', 'provider_id' => $userId])->first();
        if ($user) {
            Log::info('Facebook Deletion', ['user' => $user->id]);
            DeleteUser::dispatch($user);

            JobLog::create([
                'name' => 'facebook:user-deletion',
                'result' => $user->id,
            ]);
        }

        return response()->json([
            'url' => url('/facebook/data-deletion/status?code=' . $confirmation),
            'confirmation_code' => $confirmation,
        ]);
    }

    public function status(Request $request)
    {
        $code = $request->query('code');
        return "Data deletion processed. Confirmation code: {$code}";
    }

    public function generate(Request $request)
    {
        if (app()->isProduction()) {
            abort(404);
        }

        $secret = config('services.facebook.client_secret');

        $payload = json_encode([
            'user_id' => $request->query('user_id', '123456789'),
            'issued_at' => time(),
        ]);
        $payloadB64 = rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
        $sig = hash_hmac('sha256', $payloadB64, $secret, true);
        $sigB64 = rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');
        return $sigB64 . '.' . $payloadB64;
    }

    private function parseSignedRequest($signedRequest, $secret)
    {
        list($encodedSig, $payload) = explode('.', $signedRequest, 2);

        $sig = $this->base64UrlDecode($encodedSig);
        $data = json_decode($this->base64UrlDecode($payload), true);

        $expectedSig = hash_hmac('sha256', $payload, $secret, true);

        if (!hash_equals($expectedSig, $sig)) {
            return null;
        }

        return $data;
    }

    private function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
