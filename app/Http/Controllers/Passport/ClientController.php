<?php

namespace App\Http\Controllers\Passport;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Rules\RedirectRule;

class ClientController extends Controller
{
    /**
     * Create a client controller instance.
     */
    public function __construct(
        protected ClientRepository $clients,
        protected ValidationFactory $validation,
        protected RedirectRule $redirectRule
    ) {}

    /**
     * Store a new client.
     */
    public function store(Request $request): JsonResponse
    {
        $this->validation->make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'redirect' => ['required', $this->redirectRule],
            'confidential' => 'boolean',
        ])->validate();

        $client = $this->clients->createAuthorizationCodeGrantClient(
            $request->name,
            explode(',', $request->redirect),
            (bool) $request->input('confidential', true),
            $request->user(),
        );

        return response()->json([
            'secret' => $client->plainSecret,
        ]);
    }
}
