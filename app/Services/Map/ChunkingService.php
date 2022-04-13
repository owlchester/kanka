<?php

namespace App\Services\Map;

use App\Models\Map;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ChunkingService
{
    /** @var Map */
    protected $map;

    /** @var \Intervention\Image\Image */
    protected $original;

    protected $width = 0;
    protected $height = 0;

    protected $maxZoom = 8;
    protected $minZoom = 8;

    protected $maxZoomThreshold = 14;

    protected $tileSize = 256;

    protected $tileFormat = 'png';
    protected $tileOverlap = 1;

    public function map(Map $map): self
    {
        $this->map = $map;
        return $this;
    }

    public function chunk(): bool
    {
        // Get original image
        $img = $this->map->image;

        // Load the image into memory
        $image = Storage::disk('public')->get($img);
        dump("Chunking image " . $img);
        $this->original = Image::make($image);

        $this->width = $this->original->width();
        $this->height = $this->original->height();
        $max = max([$this->width, $this->height]);
        dump("Max bounds is $max");
        $this->zoomLevels($max);
        dump("Generating levels " . $this->minZoom . " to " . $this->maxZoom);

        // Create the folder for storing the chunks
        $folder = 'maps/' . $this->map->id . '/chunks';
        Storage::deleteDirectory($folder);
        Storage::makeDirectory($folder);

        dump("Creating " . $this->minZoom . " levels");

        for($level = $this->minZoom; $level <= $this->maxZoom; $level++) {
            dump('creating chunks for level ' . $level);
            $levelFolder = $folder . '/' . $level;
            Storage::makeDirectory($levelFolder);

            // Get the scale and dimension of the image tile we're creating, based on the level
            $scale = $this->scale($level);
            list($width, $height) = $this->dimension($scale);

            $this->createTile($width, $height, $level, $levelFolder);
        }

        unset($this->original);

        // Update the map's min/max zoom levels
        $this->map->min_zoom = $this->minZoom;
        $this->map->max_zoom = $this->maxZoom;
        // Set initial zoom in bounds
        if ($this->map->initial_zoom > $this->maxZoom || $this->map->initial_zoom < $this->minZoom) {
            $this->map->initial_zoom = max($this->minZoom, min($this->maxZoom, $this->map->initial_zoom));
        }
        $this->map->timestamps = false;
        $this->map->saveObserver = false;
        $this->map->savingObserver = false;
        $this->map->save();

        return true;
    }

    /**
     * @param int $level
     * @return float
     */
    protected function scale(int $level): float
    {
        $max = $this->maxZoom - 1;
        return pow(0.5, $max - $level);
    }

    /**
     * @param float $scale
     * @return int[]
     */
    protected function dimension(float $scale): array
    {
        $width = (int) ceil($this->width * $scale);
        $height = (int) ceil($this->height * $scale);
        //dump("Checking dimensions for scale $scale (" . $this->width . 'x' . $this->height . ") => $width x $height");
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
        list($posX, $posY) = $this->tileBoundsPosition($col, $row);

        $width = $this->tileSize + 2 * $this->tileOverlap;
        $height = $this->tileSize + 2 * $this->tileOverlap;
        $newWidth = min($width, $w - $posX);
        $newHeight = min($height, $h - $posY);

        // Make sure the new height and width doesn't get bigger than the available image size
        //dump("$col / $row (max $w x $h)");
        //dump("Building a $newWidth x $newHeight image, offset at $posX x $posY");

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


    protected function createTile(int $width, int $height, int $level, string $levelFolder)
    {
        $this->original->backup();
        $this->original->resize($width, $height);

        Storage::put(
            $levelFolder . '/base.png',
            (string)$this->original->encode($this->tileFormat, 70),
            'public'
        );

        list($cols, $rows) = $this->countTiles($width, $height);
        //dump("Create title for level $level");
        //dump("cols $cols rows $rows ($width x $height)");

        foreach (range(0, $cols -1) as $col) {
            //dump("- Col $col");
            foreach (range(0, $rows -1) as $row) {
                $file = $col . '_' . $row . '.' . $this->tileFormat;
                //dump('tile ' . $levelFolder . '/' . $file);
                //dump("width $width height $height");
                //list($w, $h, $x, $y) = $this->tileBounds($level, $col, $row, $width, $height);
                $bounds = $this->tileBounds($col, $row, $width, $height);

                $tile = clone $this->original;
                /*Storage::put(
                    $levelFolder . '/' . str_replace('.', '_make.', $file),
                    (string)$tile->encode($this->tileFormat, 50),
                    'public'
                );*/

                $tile->crop($bounds['width'], $bounds['height'], $bounds['x'], $bounds['y']);

                /*Storage::put(
                    $levelFolder . '/' . str_replace('.', '_tile.', $file),
                    (string)$tile->encode($this->tileFormat, 50),
                    'public'
                );*/

                $png = Image::canvas($this->tileSize, $this->tileSize);
                $png->insert($tile);

                Storage::put(
                    $levelFolder . '/' . $file,
                    (string)$png->encode($this->tileFormat, 85),
                    'public'
                );
                unset($tile);
                unset($png);
            }
        }

        $this->original->reset();
        unset ($tmp);
    }

    /**
     * Define the minimum and maximum zoom level based on the image dimensions
     * @param int $max
     * @return $this
     */
    protected function zoomLevels(int $max): self
    {
        $this->maxZoom = min((int) ceil(log($max,2)) + 1, $this->maxZoomThreshold);
        $this->levelMin = (int) floor(log($max, 2));
        return $this;
    }
}
