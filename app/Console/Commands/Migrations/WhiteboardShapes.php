<?php

namespace App\Console\Commands\Migrations;

use App\Models\Whiteboard;
use App\Models\WhiteboardShape;
use App\Models\WhiteboardStroke;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class WhiteboardShapes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whiteboards:shapes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate whiteboard to shapes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        WhiteboardShape::truncate();
        $whiteboards = Whiteboard::whereNotNull('data')->get();
        $shapes = 0;
        foreach ($whiteboards as $whiteboard) {
            $this->info('Migrating #' . $whiteboard->id);
            foreach ($whiteboard->data as $json) {
                if (! $this->validShape($json)) {
                    $this->warn('Invalid shape');

                    continue;
                }
                try {
                    $shape = new WhiteboardShape;
                    $shape->whiteboard_id = $whiteboard->id;
                    $shape->created_by = $whiteboard->created_by;

                    $shape->x = floor($json['x'] * 1000);
                    $shape->y = floor($json['y'] * 1000);
                    $shape->scale_x = floor($json['scaleX'] * 1000);
                    $shape->scale_y = floor($json['scaleY'] * 1000);
                    $shape->width = $json['width'];
                    $shape->height = $json['height'];
                    $shape->rotation = Arr::get($json, 'rotation', 0);
                    $shape->is_locked = Arr::get($json, 'locked', false);
                    $shape->type = $this->type($json);
                    $shape->shape = $this->shape($json);

                    $shape->save();
                    $shapes++;

                    if ($shape->type === 'drawing') {
                        $this->draw($shape, $json);
                    }
                } catch (\Exception $e) {
                    dd($json);
                }
            }
        }

        $this->info('Migrated ' . $shapes . ' shapes.');
    }

    protected function type($json): string
    {
        return $json['type'] === 'group' ? 'drawing' : $json['type'];
    }

    protected function shape($json): array
    {
        if ($json['type'] === 'text') {
            return [
                'text' => Arr::get($json, 'text'),
                'fill' => Arr::get($json, 'fill'),
                'fontSize' => Arr::get($json, 'fontSize'),
            ];
        } elseif ($json['type'] === 'image') {
            return [
                'uuid' => $json['uuid'],
            ];
        } elseif ($json['type'] === 'entity') {
            return [
                'entity' => $json['entity'],
            ];
        } elseif ($json['type'] === 'rect') {
            return [
                'fill' => Arr::get($json, $json['fill']),
            ];
        }

        return [

        ];
    }

    protected function validShape($json): bool
    {
        return Arr::has($json, ['width', 'height', 'x', 'y']) && ! empty($json['width']) && ! empty($json['height']);
    }

    protected function draw(WhiteboardShape $shape, array $json)
    {
        foreach ($json['children'] as $child) {
            $stroke = new WhiteboardStroke;
            $stroke->shape_id = $shape->id;
            $stroke->points = $this->packFlatPoints($child['points']);
            $stroke->color = $this->color($child['fill']);
            $stroke->width = Arr::get($child, 'strokeWidth', 1);
            $stroke->save();
        }
    }

    protected function color(string $color, int $alpha = 255): int
    {
        $color = trim($color);

        // HEX: #rgb or #rrggbb
        if ($color[0] === '#') {
            $hex = substr($color, 1);

            if (strlen($hex) === 3) {
                $r = hexdec(str_repeat($hex[0], 2));
                $g = hexdec(str_repeat($hex[1], 2));
                $b = hexdec(str_repeat($hex[2], 2));
            } elseif (strlen($hex) === 6) {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            } else {
                throw new InvalidArgumentException("Invalid HEX color: $color");
            }

            return (($r & 0xFF) << 24)
                | (($g & 0xFF) << 16)
                | (($b & 0xFF) << 8)
                | ($alpha & 0xFF);
        }

        // HSL: hsl(h, s%, l%)
        if (stripos($color, 'hsl(') === 0) {
            return $this->hslToRgbaInt($color, $alpha);
        }

        throw new InvalidArgumentException("Unsupported color format: $color");
    }

    protected function hslToRgbaInt(string $hsl, int $alpha = 255): int
    {
        // Matches:
        // hsl(233, 27%, 13%)
        // hsl(233 27% 13%)
        // hsl(233 27% 13% / 0.5)
        if (! preg_match(
            '/hsl\(\s*([\d.]+)(?:deg)?[\s,]+([\d.]+)%[\s,]+([\d.]+)%(?:\s*\/\s*([\d.]+))?\s*\)/i',
            $hsl,
            $m
        )) {
            throw new InvalidArgumentException("Invalid HSL: $hsl");
        }

        [$h, $s, $l] = [(float) $m[1], (float) $m[2] / 100, (float) $m[3] / 100];
        $h = fmod($h, 360) / 360;

        if ($s == 0) {
            $r = $g = $b = $l;
        } else {
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;

            $r = $this->hueToRgb($p, $q, $h + 1 / 3);
            $g = $this->hueToRgb($p, $q, $h);
            $b = $this->hueToRgb($p, $q, $h - 1 / 3);
        }

        $ri = (int) round($r * 255);
        $gi = (int) round($g * 255);
        $bi = (int) round($b * 255);

        return (($ri & 0xFF) << 24)
            | (($gi & 0xFF) << 16)
            | (($bi & 0xFF) << 8)
            | ($alpha & 0xFF);
    }

    protected function hueToRgb(float $p, float $q, float $t): float
    {
        if ($t < 0) {
            $t += 1;
        }
        if ($t > 1) {
            $t -= 1;
        }
        if ($t < 1 / 6) {
            return $p + ($q - $p) * 6 * $t;
        }
        if ($t < 1 / 2) {
            return $q;
        }
        if ($t < 2 / 3) {
            return $p + ($q - $p) * (2 / 3 - $t) * 6;
        }

        return $p;
    }

    protected function packFlatPoints(array $points, int $scale = 1000): string
    {
        $bin = '';
        $count = count($points);

        if ($count % 2 !== 0) {
            throw new InvalidArgumentException('Point array must have even length');
        }

        for ($i = 0; $i < $count; $i += 2) {
            $x = (int) round($points[$i] * $scale);
            $y = (int) round($points[$i + 1] * $scale);

            $bin .= pack('q', $x);
            $bin .= pack('q', $y);
        }

        return $bin;
    }
}
