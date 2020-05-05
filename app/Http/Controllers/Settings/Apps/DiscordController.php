<?php


namespace App\Http\Controllers\Settings\Apps;


use App\Http\Controllers\Controller;
use App\Jobs\DiscordRoleJob;
use App\Jobs\Emails\SubscriptionFailedEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Notifications\Header;
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
//        $this->discord
//            ->user($request->user())
//            ->addRoles();


//        $request->user()->notify(new Header(
//            'subscriptions.failed',
//            'far fa-credit-card',
//            'red'
//        ));
//
//        // Notify admin
//        SubscriptionFailedEmailJob::dispatch($request->user());
//
//        // Set the subscription to end when it's supposed to end (admittedly, this is already passed)
//        SubscriptionEndJob::dispatch($request->user())->delay(
//            $request->user()->subscription('kanka')->ends_at
//        );
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
                ->validate($request->get('code', ''))
                ->addServer()
                ->addRoles();

            return response()->redirectToRoute('settings.apps')->withSuccess(
                __('settings.apps.discord.success.add')
            );
        } catch (Exception $e) {
            dd($e->getMessage());
            return response()->redirectToRoute('settings.apps')->withError(
                __('settings.apps.discord.errors.add')
            );
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
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
