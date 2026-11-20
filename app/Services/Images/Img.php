<?php

namespace App\Services\Images;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Img
{
    private string $crop = '';

    private string $base = 'user';

    private ?int $focusX = null;

    private ?int $focusY = null;

    private function __construct(
        private readonly string $path,
    ) {}

    public static function for(string $path): self
    {
        return new self($path);
    }

    public function crop(int $width, ?int $height = null): self
    {
        if ($width !== 0) {
            $height ??= $width;
            $this->crop = "{$width}x{$height}/";
        }

        return $this;
    }

    public function focus(?int $x, ?int $y): self
    {
        $this->focusX = $x;
        $this->focusY = $y;

        return $this;
    }

    public function base(?string $base = 'user'): self
    {
        $this->base = $base ?: 'user';

        return $this;
    }

    public function url(): string
    {
        $key = (string) config('thumbor.key');
        $enabled = $key !== '';

        // Self-hosted with no s3/minio instance or SVG files load directly from storage
        if (! $enabled || Str::contains($this->path, '?') || Str::endsWith($this->path, '.svg')) {
            return Storage::url($this->path);
        }

        $s3 = $this->base === 'app'
            ? (string) config('thumbor.bases.app')
            : (string) config('thumbor.bases.user');

        $img = Str::before($this->path, '?');
        $full = $s3 . $img;

        $filter = ! empty($this->focusX)
            ? 'filters:focal(' . ($this->focusX - 10) . 'x' . (($this->focusY ?? 0) - 10) . ':' . ($this->focusX + 10) . 'x' . (($this->focusY ?? 0) + 10) . ')/'
            : 'smart/';

        // Local instance with Docker / MinIO
        if ($key === 'local') {
            return config('thumbor.url') . 'unsafe/' . $this->crop . $filter
                . app()->environment() . '/' . urlencode($img);
        }

        if (Str::contains((string) config('thumbor.url'), 'th.kanka.io')) {
            if (! app()->isProduction()) {
                $img = app()->environment() . '/' . $img;
                $full = $s3 . $img;
            }

            $thumborUrl = $this->crop . $filter . $full;
            $sign = $this->sign($thumborUrl, $key);

            return config('thumbor.url') . $sign . '/' . $this->crop . $filter
                . 'src/' . $img;
        }

        $thumborUrl = $this->crop . $filter . $full;
        $sign = $this->sign($thumborUrl, $key);

        return config('thumbor.url') . $this->base . '/' . $sign . '/' . $this->crop . $filter
            . 'src/' . urlencode($img);
    }

    private function sign(string $url, string $key): string
    {
        $signature = hash_hmac('sha1', $url, $key, true);

        return strtr(base64_encode($signature), '/+', '_-');
    }
}
