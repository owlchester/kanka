<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function subs()
    {
        $stats = [
            'day' => 0,
            'week' => 0,
            'month' => 0,
            'year' => 0,
            'more' => 0
        ];

        $db = DB::select("
SELECT s.created_at as subbed, u.created_at as created
FROM subscriptions as s LEFT JOIN users as u on u.id = s.user_id
WHERE s.stripe_status = 'active' and u.created_at is not null");
        foreach ($db as $stat) {
            $start = new Carbon($stat->created);
            $diff = $start->diffinDays($stat->subbed);

            if ($diff <= 1) {
                $stats['day']++;
            } elseif ($diff <= 7) {
                $stats['week']++;
            } elseif ($diff <= 30) {
                $stats['month']++;
            } elseif ($diff <= 365) {
                $stats['year']++;
            } else {
                $stats['more']++;
            }
        }

        return view('admin.stats.subs')
            ->with('stats', $stats);
    }
}
