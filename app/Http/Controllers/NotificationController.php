<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'shadow']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set all notifications as read
        Auth::user()->unreadNotifications->markAsRead();

        return view('notifications.index');
    }

    /**
     * Refresh the notification list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refresh()
    {
        $unreadNotifications = count(Auth::user()->unreadNotifications);
        $notifications = Auth::user()->notifications()->take(5)->get();
        $body = view('notifications.list', compact(
            'notifications'
        ))->render();

        return response()->json([
            'body' => $body,
            'count' => $unreadNotifications
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        foreach (Auth::user()->notifications as $notification) {
            if ($notification->id == $id) {
                $notification->delete();
            }
        }
    }
}
