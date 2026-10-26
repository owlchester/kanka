<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileAvatar;
use App\Http\Requests\StoreSettingsProfile;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return view('settings.profile', compact('user'));
    }

    public function update(StoreSettingsProfile $request)
    {
        if ($request->ajax()) {
            return response()->json();
        }
        /** @var User $user */
        $user = $request->user();

        $user->saveSettings($request->only(['settings.hide_subscription', 'settings.marketplace_name', 'settings.pronouns', 'settings.link']))
            ->update($request->only('name', 'has_last_login_sharing', 'avatar', 'profile'));

        return redirect()
            ->route('settings.profile')
            ->with('success', trans('settings.profile.success'));
    }

    public function uploadAvatar(StoreProfileAvatar $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $previousAvatar = $user->avatar;
        $avatar = $request->file('avatar')->storePublicly($user->imageStoragePath());

        $user->forceFill(['avatar' => $avatar])->saveQuietly();

        if ($previousAvatar && $previousAvatar !== 'users/default.png') {
            Storage::delete($previousAvatar);
        }

        return response()->json([
            'avatar' => $user->fresh()->getAvatarUrl(200),
            'has_avatar' => true,
            'message' => __('settings.profile.avatar_success'),
        ]);
    }

    public function removeAvatar(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $avatar = $user->avatar;

        $user->forceFill(['avatar' => null])->saveQuietly();

        if ($avatar && $avatar !== 'users/default.png') {
            Storage::delete($avatar);
        }

        return response()->json([
            'avatar' => asset('/images/defaults/avatar.svg'),
            'has_avatar' => false,
            'message' => __('settings.profile.avatar_success'),
        ]);
    }
}
