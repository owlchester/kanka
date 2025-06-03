<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Events\DiagnosingHealth;
use Illuminate\Support\Facades\Event;

class HealthController extends Controller
{
    public function index()
    {
        $exception = null;

        try {
            Event::dispatch(new DiagnosingHealth);
        } catch (\Throwable $e) {
            if (app()->hasDebugModeEnabled()) {
                throw $e;
            }

            report($e);

            $exception = $e->getMessage();
        }

        return response()->view('health', [
            'exception' => $exception,
        ], status: $exception ? 500 : 200);
    }
}
