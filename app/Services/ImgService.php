<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImgService
{
    /** @var string  */
    protected $crop = '';

    /** @var bool Called from console */
    protected $console = false;

    /** @var string user or app */
    protected $base;

    /** @var string s3 url */
    protected $s3;

    /** @var bool */
    protected $enabled;

    /** @var bool if the device supports webp */
    protected $nowebp;

    public function __construct()
    {
        $this->enabled = !empty(config('thumbor.key'));
    }

    /**
     * @return $this
     */
    public function console(): self
    {
        $this->console = true;
        return $this;
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
     * @return $this
     */
    public function resetCrop(): self
    {
        $this->crop = '';
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
        if(!$this->console) {
            $this->base();
        }

        $img = Str::before($img, '?');
        $full = $this->s3 . $img;
        $thumborUrl = $this->crop . $full;
        $sign = $this->sign($thumborUrl);

        return config('thumbor.url') . $this->base . '/' . $sign . '/' . $this->crop
            . 'src/' . urlencode($img)
            . ($this->nowebp() ? '?webpfallback' : null)
        ;
    }

    /**
     * Safari / iPhone devices don't support webp
     * @return bool
     */
    public function nowebp(): bool
    {
        if (!empty($this->nowebp)) {
            return $this->nowebp;
        }
        // If the browser doesn't bother telling us, we assume they do
        if (empty($_SERVER['HTTP_ACCEPT'])) {
            return false;
        }
        $accept = strtolower($_SERVER['HTTP_ACCEPT']);
        return $this->nowebp = !Str::contains($accept, 'image/webp');
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
