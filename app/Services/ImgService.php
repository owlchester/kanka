<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImgService
{
    protected string $crop = '';

    /** @var bool If true, running locally with docker/minio */
    protected bool $local = false;

    /** @var bool If true, use the new th.kanka.io system */
    protected bool $new = false;

    /** @var bool Called from console */
    protected bool $console = false;

    /** @var string user or app */
    protected string $base;

    /** @var string s3 url */
    protected string $s3;

    protected bool $enabled;

    protected ?int $focusX;

    protected ?int $focusY;

    public function __construct()
    {
        $this->enabled = ! empty(config('thumbor.key'));
        $this->local = config('thumbor.key') === 'local';
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
     * @return $this
     */
    public function new(): self
    {
        $this->new = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function crop(int $width, ?int $height = null): self
    {
        if ($width !== 0) {
            if ($height === null) {
                $height = $width;
            }
            $this->crop = "{$width}x{$height}/";
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function focus(int $x, int $y): self
    {
        $this->focusX = $x;
        $this->focusY = $y;

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
     * @return $this
     */
    public function reset(): self
    {
        $this->crop = '';
        $this->focusX = null;
        $this->focusY = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function base(?string $base = 'user'): self
    {
        //        if (!empty($this->s3)) {
        //            return $this;w
        //        }
        $this->base = $base;
        if ($base === 'app') {
            $this->s3 = config('thumbor.bases.app');
        } else {
            $this->s3 = config('thumbor.bases.user');
        }

        return $this;
    }

    public function url(string $img): string
    {
        // Self-hosted with no s3/minio instance or SVG files load directly from the storage
        if (! $this->enabled || Str::contains($img, '?') || Str::endsWith($img, '.svg')) {
            return Storage::url($img);
        }

        // Default base
        if (! $this->console) {
            $this->base();
        }

        $img = Str::before($img, '?');
        $full = $this->s3 . $img;
        $filter = 'smart/';
        if (! empty($this->focusX)) {
            // left x top:right x bottom
            $filter = 'filters:focal(' . ($this->focusX - 10) . 'x' . ($this->focusY - 10) . ':' . ($this->focusX + 10) . 'x' . ($this->focusY + 10) . ')/';
            $this->focusX = $this->focusY = null;
        }
        $thumborUrl = $this->crop . $filter . $full;
        $sign = $this->sign($thumborUrl);

        // If we're on a local instance, it's a lot easier, everything is in minio
        if ($this->local) {
            return config('thumbor.url') . 'unsafe/' . $this->crop . $filter
                . app()->environment() . '/' . urlencode($img);
        } elseif (Str::contains(config('thumbor.url'), 'th.kanka.io')) {
            // New server
            if (! app()->isProduction()) {
                $img = app()->environment() . '/' . $img;
                $full = $this->s3 . $img;
            }
            $thumborUrl = $this->crop . $filter . $full;
            $sign = $this->sign($thumborUrl);

            return config('thumbor.url') . $sign . '/' . $this->crop . $filter
                . 'src/' . $img;
        }

        // Old system
        return config('thumbor.url') . $this->base . '/' . $sign . '/' . $this->crop . $filter
            . 'src/' . urlencode($img);
    }

    protected function sign(string $url): string
    {
        $signature = hash_hmac('sha1', $url, config('thumbor.key'), true);

        return strtr(base64_encode($signature), '/+', '_-');
    }
}
