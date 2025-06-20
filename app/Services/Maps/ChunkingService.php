<?php

namespace App\Services\Maps;

use App\Models\Map;
use App\Models\User;
use App\Notifications\Header;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class ChunkingService
{
    protected Map $map;

    /** @var \Intervention\Image\Image */
    protected $original;

    protected string $path;

    protected int $width = 0;

    protected int $height = 0;

    protected int $maxZoom = 8;

    protected int $minZoom = 8;

    protected int $levelMin = 0;

    protected int $maxBound = 0;

    protected int $maxZoomThreshold = 13;

    protected int $tileSize = 256;

    protected string $tileFormat = 'png';

    protected int $tileOverlap = 1;

    protected ImageManager $manager;

    public function map(Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function chunk(): bool
    {
        if (empty($this->map->image)) {
            throw new Exception('Map #' . $this->map->id . ' has no image.');
        }

        // Set the map chunking process
        $this->map->chunking_status = Map::CHUNKING_RUNNING;
        $this->map->saveQuietly();

        // Get original image and load it into memory
        $this->log('File ' . $this->map->image);

        $this->openOriginal();
        $this->log('Generating levels ' . $this->minZoom . ' to ' . $this->maxZoom);

        // Create the folder for storing the chunks
        $folder = 'maps/' . $this->map->id . '/chunks';
        Storage::deleteDirectory($folder);
        Storage::makeDirectory($folder);

        // create new manager instance with desired driver
        $this->manager = new ImageManager(Driver::class);

        for ($level = $this->minZoom; $level <= $this->maxZoom; $level++) {
            $this->log('creating chunks for level ' . $level);
            $levelFolder = $folder . '/' . $level;
            Storage::makeDirectory($levelFolder);

            // Get the scale and dimension of the image tile we're creating, based on the level
            $scale = $this->scale($level);
            [$width, $height] = $this->dimension($scale);

            $this->createTile($width, $height, $level, $levelFolder);
        }

        // Update the map's min/max zoom levels
        $this->finish();

        return true;
    }

    protected function scale(int $level): float
    {
        $max = $this->maxZoom - 1;

        return pow(0.5, $max - $level);
    }

    /**
     * @return int[]
     */
    protected function dimension(float $scale): array
    {
        $width = (int) ceil($this->width * $scale);
        $height = (int) ceil($this->height * $scale);

        // dump("Checking dimensions for scale $scale (" . $this->width . 'x' . $this->height . ") => $width x $height");
        return [$width, $height];
    }

    protected function countTiles(int $width, int $height): array
    {
        $cols = (int) ceil(floatval($width) / $this->tileSize);
        $rows = (int) ceil(floatval($height) / $this->tileSize);

        return [$cols, $rows];
    }

    public function tileBounds(int $col, int $row, $w, $h): array
    {
        [$posX, $posY] = $this->tileBoundsPosition($col, $row);

        $width = $this->tileSize + 2 * $this->tileOverlap;
        $height = $this->tileSize + 2 * $this->tileOverlap;
        $newWidth = min($width, $w - $posX);
        $newHeight = min($height, $h - $posY);

        // Make sure the new height and width doesn't get bigger than the available image size
        // dump("$col / $row (max $w x $h)");
        // dump("Building a $newWidth x $newHeight image, offset at $posX x $posY");

        return ['x' => $posX, 'y' => $posY, 'height' => $newHeight, 'width' => $newWidth];
    }

    protected function tileBoundsPosition(int $column, int $row): array
    {
        $offsetX = $column === 0 ? 0 : $this->tileOverlap;
        $offsetY = $row === 0 ? 0 : $this->tileOverlap;
        $x = ($column * $this->tileSize) - $offsetX;
        $y = ($row * $this->tileSize) - $offsetY;

        return [$x, $y];
    }

    protected function createTile(int $width, int $height, int $level, string $levelFolder): void
    {
        $original = $this->generate($width, $height);

        /*Storage::put(
            $levelFolder . '/base.png',
            (string)$this->original->encode($this->tileFormat, 70),
            'public'
        );*/

        [$cols, $rows] = $this->countTiles($width, $height);
        // dump("Create title for level $level");
        // dump("cols $cols rows $rows ($width x $height)");
        // $total = $cols * $rows;

        foreach (range(0, $cols - 1) as $col) {
            // dump("- Col $col");
            foreach (range(0, $rows - 1) as $row) {
                $file = $col . '_' . $row . '.' . $this->tileFormat;
                // dump('tile ' . $levelFolder . '/' . $file);
                // dump("width $width height $height");
                $bounds = $this->tileBounds($col, $row, $width, $height);

                // We need to clone the original, because Image::make($this->original) crops
                // the original for some reason.
                // $tile = clone $image;
                /*Storage::put(
                    $levelFolder . '/' . str_replace('.', '_make.', $file),
                    (string)$tile->encode($this->tileFormat, 50),
                    'public'
                );*/

                $image = clone $original;
                $image->crop($bounds['width'], $bounds['height'], $bounds['x'], $bounds['y']);

                /*Storage::put(
                    $levelFolder . '/' . str_replace('.', '_tile.', $file),
                    (string)$tile->encode($this->tileFormat, 50),
                    'public'
                );*/

                // Create a 256x256 blank transparent canvas on which we'll insert the crop. This is to make sure each
                // image create is a square tile (and avoid distortion in leafletjs)
                $png = $this->manager->create($this->tileSize, $this->tileSize);
                $png->place($image);

                Storage::put(
                    $levelFolder . '/' . $file,
                    (string) $png->toPng(),
                    'public'
                );
                // unset($tile);
                unset($png, $image);
            }
        }

        unset($original);
    }

    /**
     * Define the minimum and maximum zoom level based on the image dimensions
     */
    protected function zoomLevels(int $max): self
    {
        $this->maxZoom = min((int) ceil(log($max, 2)), $this->maxZoomThreshold);
        $this->levelMin = (int) floor(log($max, 2));

        return $this;
    }

    /**
     * Finish the process by updating the map
     */
    protected function finish(): self
    {
        $this->map->chunking_status = Map::CHUNKING_FINISHED;
        $this->map->min_zoom = $this->minZoom;
        $this->map->max_zoom = $this->maxZoom;
        $this->map->center_x = 0;
        $this->map->center_y = 0;
        // Set initial zoom in bounds
        if ($this->map->initial_zoom > $this->maxZoom || $this->map->initial_zoom < $this->minZoom) {
            $this->map->initial_zoom = max($this->minZoom, min($this->maxZoom, $this->map->initial_zoom));
        }
        $this->map->saveQuietly();
        Log::info('Saved map #' . $this->map->id);
        if ($this->map->entity->creator) {
            /** @var User $user */
            $user = $this->map->entity->creator;
            $user->notify(new Header(
                'map.chunked',
                'fa-regular fa-map',
                'success',
                ['name' => $this->map->name]
            ));

            Log::info('Notified user #' . $this->map->entity->created_by);
        }

        // Cleanup the locally downloaded file
        Storage::disk('local')->delete($this->map->image);

        return $this;
    }

    protected function log($log): self
    {
        Log::info($log);

        return $this;
    }

    protected function generate(int $width, int $height)
    {
        $image = $this->manager->read($this->path);

        return $image->resize($width, $height);
    }

    /**
     * Open the original image
     */
    protected function openOriginal(): self
    {
        $this->path = Storage::disk('local')->path($this->map->image);

        // Download from s3 to local
        $s3 = Storage::disk('s3')->get($this->map->image);
        Storage::disk('local')->put(
            $this->map->image,
            $s3
        );

        $original = $this->manager->read($this->path);

        $this->width = $original->width();
        $this->height = $original->height();

        $this->maxBound = max([$this->width, $this->height]);
        $this->zoomLevels($this->maxBound);

        unset($s3, $original);

        return $this;
    }
}
