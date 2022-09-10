<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PasswordSecurity extends Model
{
    protected $table = 'password_securities';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id', 'google2fa_enable', 'google2fa_secret',
    ];

    /**
    * A Google2FA belongsTo a user
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

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
        if (isset($user->PasswordSecurity)) {
            $google2Fa = new Google2FA();
            //$google2Fa->setAllowInsecureCallToGoogleApis(true);
            $google2FaUrl = $google2Fa->getQRCodeUrl(
                $user->name,
                $user->email,
                $user->PasswordSecurity->google2fa_secret
            );
        }
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        $qrImage = $writer->writeString($google2FaUrl);
        return $qrImage;
    }
}
