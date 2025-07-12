<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Passport\Token;
use Laravel\Passport\Client;

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
    public function index()
    {
        $tokens = Token::where('user_id', auth()->user()->id)
            ->where('revoked', false)
            ->orderByDesc('created_at')
            ->get();
        
        // Retrieving all the user's connections to third-party OAuth app clients.
        $applications = $tokens->load('client')
            ->reject(fn (Token $token) => $token->client->firstParty())
            ->values();

        $clients = Client::where('user_id', auth()->user()->id)
            ->where('revoked', false)
            ->orderByDesc('created_at')
            ->get();

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:90'],
        ]);

        $accessToken = auth()->user()->createToken($validated['name'])->accessToken;

        return redirect()->route('settings.api')->with('new_token', $accessToken);
    }

    public function revoke(Request $request, Token $token)
    {
        $revokedToken = Token::where('user_id', auth()->user()->id)
            ->where('id', $token->id)
            ->first();

        $revokedToken->revoke();

        return redirect()->route('settings.api')->with('success', 'Token deleted successfully.');
    }
}
