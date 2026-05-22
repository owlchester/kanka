<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\UserDevice;
use App\Services\Auth\DeviceService;
use App\Services\Auth\UserAgentParser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index(Request $request, UserAgentParser $parser): View
    {
        $currentToken = $request->cookie(DeviceService::COOKIE_NAME);

        $devices = auth()->user()
            ->devices()
            ->orderByDesc('last_active_at')
            ->get()
            ->map(fn (UserDevice $device) => [
                'id' => $device->id,
                'name' => $parser->parse($device->user_agent),
                'ip_address' => $device->ip_address,
                'last_active_at' => $device->last_active_at,
                'is_current' => $device->token === $currentToken,
            ]);

        return view('settings.security', compact('devices'));
    }

    public function revoke(Request $request, UserDevice $device, DeviceService $deviceService): RedirectResponse
    {
        abort_if($device->user_id !== auth()->id(), 403);

        $deviceService->revoke($device);

        return redirect()->route('settings.security')
            ->with('success', __('settings/security.devices.revoked'));
    }

    public function revokeOthers(Request $request, DeviceService $deviceService): RedirectResponse
    {
        $deviceService->revokeOthers(auth()->user());

        return redirect()->route('settings.security')
            ->with('success', __('settings/security.devices.revoked_others'));
    }
}
