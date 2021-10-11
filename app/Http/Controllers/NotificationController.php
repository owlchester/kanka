<?php

namespace App\Http\Controllers;

use App\Notifications\Header;

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
        $user = auth()->user();

        $notifications = $user->notifications()->paginate();
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Refresh the notification list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refresh()
    {
        $user = auth()->user();
        $unreadNotifications = count($user->unreadNotifications);

        // User is requesting to mark all notifications as read
        if (request()->has('read-all')) {
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
