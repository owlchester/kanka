<?php
/**
 * Description of
 *
 * @author Jeremy Payne hello@kanka.io
 * 19/05/2020
 */


namespace App\Http\Controllers\LFGM;


use App\Exceptions\TranslatableException;
use App\Facades\UserCache;
use App\Http\Controllers\Controller;
use App\Services\LfgmService;
use Illuminate\Http\Request;

class HookController extends Controller
{
    /** @var LfgmService */
    protected $service;

    public function __construct(LfgmService $lfgmService)
    {
        $this->middleware(['auth', 'identity', 'shadow']);
        $this->service = $lfgmService;
    }

    /**
     * @param string $uuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function sync(string $uuid)
    {
        try {
            $campaigns = auth()->user()->campaigns;
            $uuid = $this->service->uuid($uuid);
            return view('lfgm.sync', compact('campaigns', 'uuid'));
        } catch (\Exception $e) {
            return response()
                ->redirectToRoute('home')
                ->withErrors(__('lfgm.errors.invalid_uuid'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveSync(Request $request)
    {
        try {
            $campaign = $this->service->sync($request);
            return redirect()
                ->to('/' . app()->getLocale() . '/campaign/' . $campaign->id . '/')
                ->withSuccess(__('lfgm.successes.synced'));
        } catch (TranslatableException $e) {
            return response()
                ->redirectToRoute('lfgm.sync', ['uuid' => $request->post('uuid')])
                ->withErrors(__($e->getMessage()));
        } catch (\Exception $e) {
            return response()
                ->redirectToRoute('lfgm.sync', ['uuid' => $request->post('uuid')])
                ->withErrors(__('lfgm.errors.general_error'));
        }
    }
}
