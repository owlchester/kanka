<?php


namespace App\Facades;


use App\Services\ImgService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Img
 * @package App\Facades
 *
 * @method static string url(string $img, string $base = 'user')
 * @method static self|Img crop(int $width, int $height)
 * @method static self|Img resetCrop()
 * @method static self|Img base(string $base)
 * @method static self|Img console()
 * @method static bool nowebp()
 *
 * @see ImgService
 */
class Img extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'img';
    }
}
{

}
