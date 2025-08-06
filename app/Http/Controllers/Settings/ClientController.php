<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreClient;
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
        $this->authorize('update', $client);
        
        $client = Client::where('user_id', auth()->user()->id)
            ->where('id', $client->id)
            ->first();

        return view('settings.client.update', ['client' => $client]);
    }

    public function update(StoreClient $request, Client $client)
    {
        $this->authorize('update', $client);

        $updatedClient = Client::where('user_id', auth()->user()->id)
            ->where('id', $client->id)
            ->first();

        $updatedClient->forceFill($request->only(['name', 'redirect']))->save();

        return redirect()->route('settings.api', ['clients' => 1])->with('success', 'Client updated successfully.');
    }

    public function store(StoreClient $request)
    {
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Creating an OAuth app client that belongs to the given user.
        $client = app(ClientRepository::class)->createAuthorizationCodeGrantClient(
            user: auth()->user(),
            name: $request['name'],
            redirectUris: [$request['redirect']],
            confidential: true,
            enableDeviceFlow: true
        );

        return redirect()->route('settings.api', ['clients' => 1])->with('new_token', $client->plainSecret);
    }

    public function revoke(Request $request, Client $client)
    {
        $this->authorize('update', $client);
 
        $client = Client::where('user_id', auth()->user()->id)
            ->where('id', $client->id)
            ->first();

        $client->forceFill(['revoked' => true])->save();

        return redirect()->route('settings.api')->with('success', 'Client deleted successfully.');
    }
}
