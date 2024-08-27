<?php

namespace App\Http\Controllers;

use App\Services\Layout\NavigationService;
use App\Models\User;

class NotificationController extends Controller
{
    protected NavigationService $navigationService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NavigationService $navigationService)
    {
        $this->middleware(['auth', 'identity']);
        $this->navigationService = $navigationService;
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

    public function refresh()
    {
        /** @var User $user */
        $user = auth()->user();

        return response()->json(
            $this->navigationService->user($user)->pull()
        );
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();

        return redirect()
            ->route('notifications')
            ->with('success', __('notifications.clear.success'))
        ;
    }
}
