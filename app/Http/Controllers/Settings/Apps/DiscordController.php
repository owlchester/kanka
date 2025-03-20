<?php

namespace App\Http\Controllers\Settings\Apps;

use App\Http\Controllers\Controller;
use App\Services\DiscordService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiscordController extends Controller
{
    protected DiscordService $discord;

    public function __construct(DiscordService $discord)
    {
        $this->middleware(['auth', 'identity']);
        $this->discord = $discord;
    }

    public function callback(Request $request)
    {
        try {
            $this->discord
                ->user($request->user())
                ->validate($request->get('code', ''))
                ->addServer()
                ->addRoles();

            return response()->redirectToRoute('settings.apps')->withSuccess(
                __('settings.apps.discord.success.add')
            );
        } catch (Exception $e) {
            Log::error('Discord sync error for ' . $request->user()->id . ': ' . $e->getMessage());

            return response()->redirectToRoute('settings.apps')->withError(
                __('settings.apps.discord.errors.add')
            );
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->discord
                ->user($request->user())
                ->remove();

            return response()->redirectToRoute('settings.apps')->withSuccess(
                __('settings.apps.discord.success.remove')
            );
        } catch (Exception $e) {
            return response()->redirectToRoute('settings.apps')->withError(
                __('settings.apps.discord.errors.remove')
            );
        }
    }
}
