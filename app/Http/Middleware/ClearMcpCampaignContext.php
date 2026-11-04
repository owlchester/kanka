<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use App\Facades\Permissions;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearMcpCampaignContext
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } finally {
            CampaignLocalization::clearCampaign();
            Permissions::reload()->reset();
        }
    }
}
