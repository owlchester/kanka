<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Notifications\Header;
use App\User;

class NotificationController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set all notifications as read
        /** @var User $user */
        $user = auth()->user();

        $notifications = $user->notifications()->paginate();
        // @phpstan-ignore-next-line
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    public function read($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if (empty($notification)) {
            abort(403);
        }

        $notification->markAsRead();
        return response()->json(['success' => true]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        /** @var User $user */
        $user = auth()->user();
        // @phpstan-ignore-next-line
        $unreadNotifications = count($user->unreadNotifications);

        // User is requesting to mark all notifications as read
        if (request()->has('read-all')) {
            // @phpstan-ignore-next-line
            $user->unreadNotifications->markAsRead();
            $unreadNotifications = 0;
        }

        $notifications = $user->notifications()->take(5)->get();
        $body = view('notifications.list', compact(
            'notifications'
        ))->render();

        return response()->json([
            'body' => $body,
            'count' => $unreadNotifications
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearAll()
    {
        auth()->user()->notifications()->delete();

        return redirect()
            ->route('notifications')
            ->with('success', __('notifications.clear.success'))
        ;
    }
}
