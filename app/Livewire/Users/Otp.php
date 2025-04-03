<?php

namespace App\Livewire\Users;

use App\Models\PasswordSecurity;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class Otp extends Component
{
    public $duplicates;

    public bool $clickedBefore = false;

    protected $listeners = ['refreshTable' => '$refresh']; // Listen for table refresh event

    #[Validate('required|numeric')]
    public string $otp = '';

    /*
    * Generates secret code for 2fa
    */
    public function generate2faSecretCode()
    {
        /** @var User $user */
        $user = auth()->user();

        $otp = new Google2FA;

        // Generate a new Google2FA code for User
        PasswordSecurity::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $otp->generateSecretKey(),
        ]);
        $this->dispatch('refreshTable');
    }

    /*
    * Enables 2fa for the current user.
    */
    public function enable2fa()
    {
        $this->validate();

        /** @var User $user */
        $user = auth()->user();

        // Enable OTP if the Authenticator code matches secret
        $otpModel = new Google2FA;
        $valid = $otpModel->verifyKey($user->passwordSecurity->google2fa_secret, $this->otp);

        // If OTP code is valid enable OTP
        if ($valid) {
            $user->passwordSecurity->update(['google2fa_enable' => 1]);
            // 2FA is enabled, log out the user and ask them to set up.
            auth()->logout();
            session()->flush();

            $this->redirectRoute('login', ['success' => __('settings.account.2fa.success_enable')]);
        }
        session()->flash('otp-error', __('settings.account.2fa.error_enable'));

    }

    /*
    * Disables 2fa for the current user.
    */
    public function disable2fa()
    {
        if ($this->clickedBefore) {
            /** @var User $user */
            $user = auth()->user();

            // Update disabling OTP
            $user->passwordSecurity->google2fa_enable = 0;
            $user->passwordSecurity->save();
            session()->flash('disable-success', __('settings.account.2fa.success_disable'));
        } else {
            $this->clickedBefore = true;
        }

    }

    public function render()
    {

        /** @var User $user */
        $user = auth()->user();

        return view('livewire.users.otp', ['user' => $user]);
    }
}
