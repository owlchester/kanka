<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DeviceService
{
    public const COOKIE_NAME = 'kanka_device';

    public const COOKIE_DAYS = 30;

    public function __construct(
        protected Request $request,
        protected IpResolver $ipResolver,
    ) {}

    /**
     * Find the current device from the cookie, or create a new one.
     * Queues the device cookie on the response.
     */
    public function findOrCreate(User $user): UserDevice
    {
        $token = $this->request->cookie(self::COOKIE_NAME);

        if ($token) {
            $device = UserDevice::query()->where('token', $token)
                ->where('user_id', $user->id)
                ->first();

            if ($device) {
                $device->update([
                    'session_id' => Session::getId(),
                    'ip_address' => $this->ipResolver->resolve(),
                    'last_active_at' => now(),
                ]);

                return $device;
            }
        }

        $token = Str::random(64);
        $device = UserDevice::create([
            'user_id' => $user->id,
            'token' => $token,
            'session_id' => Session::getId(),
            'ip_address' => $this->ipResolver->resolve(),
            'user_agent' => $this->request->userAgent(),
            'last_active_at' => now(),
        ]);

        Cookie::queue(
            self::COOKIE_NAME,
            $token,
            60 * 24 * self::COOKIE_DAYS,
            '/',
            null,
            config('session.secure'),
            true,
            false,
            'lax'
        );

        return $device;
    }

    /**
     * Find the device matching the current request's cookie for a given user.
     */
    public function findForUser(User $user): ?UserDevice
    {
        $token = $this->request->cookie(self::COOKIE_NAME);
        if (! $token) {
            return null;
        }

        return UserDevice::query()->where('token', $token)
            ->where('user_id', $user->id)
            ->first();
    }

    /**
     * Update session_id and last_active_at, rate-limited to once per hour.
     */
    public function touchActivity(UserDevice $device): void
    {
        if ($device->last_active_at->lt(now()->subHour())) {
            $device->update([
                'session_id' => Session::getId(),
                'ip_address' => $this->ipResolver->resolve(),
                'last_active_at' => now(),
            ]);
        } elseif ($device->session_id !== Session::getId()) {
            $device->updateQuietly(['session_id' => Session::getId()]);
        }
    }

    /**
     * Revoke a device: delete the DB record and destroy its Redis session immediately.
     */
    public function revoke(UserDevice $device): void
    {
        if ($device->session_id) {
            Session::getHandler()->destroy($device->session_id);
        }

        $device->delete();
    }

    /**
     * Revoke all devices for a user except the one matching the current cookie.
     */
    public function revokeOthers(User $user): void
    {
        $currentToken = $this->request->cookie(self::COOKIE_NAME);

        $others = UserDevice::query()->where('user_id', $user->id)
            ->when($currentToken, fn ($q) => $q->where('token', '!=', $currentToken))
            ->get();

        foreach ($others as $device) {
            $this->revoke($device);
        }
    }
}
