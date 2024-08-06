<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PasswordSecurity extends Model
{
    use HasUser;

    protected $table = 'password_securities';

    protected $fillable = [
        'user_id',
        'google2fa_enable',
        'google2fa_secret',
    ];

    /**
     * Generates the QR code for 2FA
     */
    public function getGoogleQR()
    {
        if (Auth::guest()) {
            return;
        }

        $user = Auth::user();

        $google2FaUrl = '';

        // If User has 2FA current disabled generate QR code
        if (isset($user->passwordSecurity)) {
            $google2Fa = new Google2FA();
            //$google2Fa->setAllowInsecureCallToGoogleApis(true);
            $appName = config('app.name');
            if (!app()->isProduction()) {
                $appName .= ':' . app()->environment();
            }
            $google2FaUrl = $google2Fa->getQRCodeUrl(
                $appName,
                $user->email,
                $user->passwordSecurity->google2fa_secret
            );
        }
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        return $writer->writeString($google2FaUrl);
    }
}
