<?php


namespace App\Services;


class ImgService
{
    protected $crop = '';
    protected $base;

    public function crop(int $width, int $height): self
    {
        $this->crop = "{$width}x{$height}/";
        return $this;
    }

    public function base(string $base = null): self
    {
        if ($base === 'app') {
            $this->base = 'https://kanka-app-assets.s3.eu-central-1.amazonaws.com';
        } else {
            $this->base = 'https://kanka-user-assets.s3.eu-central-1.amazonaws.com';
        }
        return $this;
    }

    public function url(string $img, string $base = 'user'): string
    {
        $this->base($base);

        $full = rtrim($this->base, '/') . '/' . $img;
        $thumborUrl = $this->crop . $full;
        $sign = $this->sign($thumborUrl);

        return 'https://images.kanka.io/users/' . $sign . '/' . $this->crop . 'src/' . $img;

    }

    protected function sign(string $url): string
    {
        $signature = hash_hmac('sha1', $url, 'miscellany', true);
        return strtr(base64_encode($signature), '/+', '_-');
    }
}
