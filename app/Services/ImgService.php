<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImgService
{
    /** @var string  */
    protected $crop = '';

    /** @var string user or app */
    protected $base;

    /** @var string s3 url */
    protected $s3;

    /** @var bool */
    protected $enabled;

    public function __construct()
    {
        $this->enabled = !empty(config('thumbor.key'));
    }

    /**
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function crop(int $width, int $height): self
    {
        if ($width !== 0) {
            $this->crop = "{$width}x{$height}/";
        }
        return $this;
    }

    /**
     * @param string|null $base
     * @return $this
     */
    public function base(string $base = 'user'): self
    {
//        if (!empty($this->s3)) {
//            return $this;
//        }
        $this->base = $base;
        if ($base === 'app') {
            $this->s3 = config('thumbor.bases.app');
        } else {
            $this->s3 = config('thumbor.bases.user');
        }
        return $this;
    }

    /**
     * @param string $img
     * @return string
     */
    public function url(string $img): string
    {
        if (!$this->enabled || Str::contains($img, '?') || Str::endsWith($img, '.svg')) {
            return Storage::url($img);
        }

        // Default base
        $this->base();

        $img = Str::before($img, '?');
        $full = $this->s3 . $img;
        $thumborUrl = $this->crop . $full;
        $sign = $this->sign($thumborUrl);

        return config('thumbor.url') . $this->base . '/' . $sign . '/' . $this->crop . 'src/' . urlencode($img);
    }

    /**
     * @param string $url
     * @return string
     */
    protected function sign(string $url): string
    {
        $signature = hash_hmac('sha1', $url, config('thumbor.key'), true);
        return strtr(base64_encode($signature), '/+', '_-');
    }
}
