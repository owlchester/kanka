<?php

namespace App\Http\Middleware;

use App\Services\Auth\DeviceService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateDeviceActivity
{
    public function __construct(protected DeviceService $deviceService) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $token = $request->cookie(DeviceService::COOKIE_NAME);

            if ($token) {
                $device = $this->deviceService->findForUser(auth()->user());

                if ($device === null) {
                    auth()->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login');
                }

                $this->deviceService->touchActivity($device);
            }
        }

        return $next($request);
    }
}
