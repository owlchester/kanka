<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Laravel\Passport\Client;
use Laravel\Passport\Token;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tokens = $request->user()->tokens()
            ->with('client')
            ->where('revoked', false)
            ->where('expires_at', '>', Date::now())
            ->orderByDesc('created_at')
            ->get();

        // Retrieving all the user's connections to third-party OAuth app clients.
        $applications = $tokens
            ->reject(fn (Token $token): bool => $token->client->revoked || $token->client->firstParty())
            ->values();

        $clients = Client::where('user_id', auth()->user()->id)
            ->where('revoked', false)
            ->orderByDesc('created_at')
            ->paginate(config('limits.pagination'), ['*'], 'clientsPage');

        $tokens = $request->user()->tokens()
            ->with('client')
            ->where('revoked', false)
            ->where('expires_at', '>', Date::now())
            ->orderByDesc('created_at')
            ->paginate(config('limits.pagination'), ['*'], 'tokensPage');

        return view('settings.api', compact('tokens', 'clients', 'applications'));
    }

    /**
     * Create a new api token form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('settings.api.create');
    }

    public function store(StoreApiToken $request)
    {
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $accessToken = auth()->user()->createToken($request['name'])->accessToken;

        return redirect()->route('settings.api')->with('new_token', $accessToken);
    }

    public function revoke(Request $request, Token $token)
    {
        $this->authorize('update', $token);

        $revokedToken = Token::where('user_id', auth()->user()->id)
            ->where('id', $token->id)
            ->first();

        $revokedToken->revoke();

        return redirect()->route('settings.api')->with('success', 'Token deleted successfully.');
    }
}
