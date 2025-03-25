<?php

namespace App\Http\Middleware;

use Closure;

class Tracking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        //        dump(session()->all());
        //        if (session()->has('tracking')) {
        //            dd(session()->get('tracking'));
        //        }
        if ($request->hasAny(['utm_campaign', 'utm_id', 'utm_source', 'utm_medium'])) {
            $data = [];
            if ($request->has('utm_id')) {
                $data['id'] = $request->get('utm_id');
            }
            if ($request->has('utm_campaign')) {
                $data['campaign'] = $request->get('utm_campaign');
            }
            if ($request->has('utm_source')) {
                $data['source'] = $request->get('utm_source');
            }
            if ($request->has('utm_medium')) {
                $data['medium'] = $request->get('utm_medium');
            }
            session()->put('tracking', $data);
        }

        //        dump(session()->all());
        return $next($request);
    }
}
