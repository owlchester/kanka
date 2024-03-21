<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserValidation;
use Illuminate\Http\Request;

class EmailValidationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validateEmail(Request $request, UserValidation $userValidation)
    {
        if (auth()->user()->id != $userValidation->user_id) {
            return response()->redirectTo(route('settings.subscription'))->withError(__('emails/validation.error'));
        }

        $userValidation->is_valid = true;
        $userValidation->saveQuietly();

        return response()->redirectTo(route('settings.subscription'))->withSuccess(__('emails/validation.success'));
    }
}
