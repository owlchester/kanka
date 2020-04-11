<?php


namespace App\Http\Controllers\Settings\Apps;


use App\Http\Controllers\Controller;
use App\Jobs\DiscordRoleJob;
use App\Services\DiscordService;
use Illuminate\Http\Request;
use Exception;

class DiscordController extends Controller
{
    /**
     * @var DiscordService
     */
    protected $discord;

    public function __construct(DiscordService $discord)
    {
        $this->middleware(['auth', 'identity', 'shadow']);
        $this->discord = $discord;
    }

    public function me(Request $request)
    {

//        DiscordRoleJob::dispatch($request->user(), false);
//
        $this->discord
            ->user($request->user())
            ->addRoles();
    }

    public function setup()
    {
        $this->discord->setup();
    }

    /**
     * @param Request $request
     */
    public function callback(Request $request)
    {
        try {
            $this->discord
                ->user($request->user())
                ->validate($request->get('code'))
                ->addToGuild();

            return response()->redirectToRoute('settings.apps')->withSuccess(
                __('settings.apps.discord.success')
            );
        } catch (Exception $e) {

            dd($e->getMessage());
            return response()->redirectToRoute('settings.apps')->withError(
                __('settings.apps.discord.error')
            );
        }

    }
}
