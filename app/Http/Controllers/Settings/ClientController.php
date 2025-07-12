<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class ClientController extends Controller
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
     * Create a new api client form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('settings.client.create');
    }

    public function edit(Client $client)
    {
        $client = Client::where('user_id', auth()->user()->id)
            ->where('id', $client->id)
            ->first();

        return view('settings.client.update', ['client' => $client]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:90'],
            'redirect' => ['required', 'string', 'max:120', 'url', 'active_url'],
        ]);

        $updatedClient = Client::where('user_id', auth()->user()->id)
            ->where('id', $client->id)
            ->first();

        $updatedClient->forceFill($validated)->save();

        return redirect()->route('settings.api')->with('success', 'Client updated successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:90'],
            'redirect' => ['required', 'string', 'max:120', 'url', 'active_url'],
        ]);

        // Creating an OAuth app client that belongs to the given user.
        $client = app(ClientRepository::class)->createAuthorizationCodeGrantClient(
            user: auth()->user(),
            name: $validated['name'],
            redirectUris: [$validated['redirect']],
            confidential: true,
            enableDeviceFlow: true
        );

        return redirect()->route('settings.api')->with('new_token', $client->plainSecret);
    }

    public function revoke(Request $request, Client $client)
    {
        $client = Client::where('user_id', auth()->user()->id)
            ->where('id', $client->id)
            ->first();

        $client->forceFill(['revoked' => true])->save();

        return redirect()->route('settings.api')->with('success', 'Client deleted successfully.');
    }
}
