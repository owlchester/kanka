<?php

namespace App\Http\Controllers\Account;

use App\Facades\Domain;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSettingsAccount;
use App\Services\Account\DeletionService;

class DeleteController extends Controller
{
    public function __construct(protected DeletionService $deletionService)
    {
        $this->middleware(['auth', 'identity', 'password.confirm']);
    }

    public function destroy(DeleteSettingsAccount $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        $this->deletionService
            ->user($request->user())
            ->request($request)
            ->delete();

        return redirect()->to(Domain::toFront('goodbye') . '?deleted=true');
    }
}
