<?php

namespace App\Services\Whiteboards\Shapes;

use App\Models\Whiteboard;
use App\Models\WhiteboardShape;
use App\Models\WhiteboardStroke;
use App\Traits\RequestAware;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class PersistanceService
{
    use RequestAware;

    protected WhiteboardShape $shape;
    protected Whiteboard $whiteboard;

    protected array $fill;

    public function shape(WhiteboardShape $shape): self
    {
        $this->shape = $shape;
        return $this;
    }

    public function whiteboard(Whiteboard $whiteboard): self
    {
        $this->whiteboard = $whiteboard;

        return $this;
    }

    public function create(): WhiteboardShape
    {
        $this->shape = new WhiteboardShape;
        $this->shape->whiteboard_id = $this->whiteboard->id;
        $this->cleanData();
        $this->shape->save();
        $this->points();
        return $this->shape;
    }

    public function save(): void
    {
        $data = $this->request->only([
            'x',
            'y',
            'width',
            'height',
            'scale_x',
            'scale_y',
            'group_id',
            'rotation',
            'is_locked',
            'z_index'
        ]);
        $this->shape->fill($data);
        $this->fillShape();

        $this->shape->save();
    }

    public function addStroke(): ?WhiteboardStroke
    {
        if (!$this->shape->isDrawing()) {
            return null;
        }

        if (!$this->request->filled('points')) {
            return null;
        }

        $stroke = new WhiteboardStroke;
        $stroke->shape_id = $this->shape->id;
        $stroke->color = $this->request->get('fill', '#cccccc');
        $stroke->width = $this->request->get('strokeWidth', 1);
        $stroke->points = $this->pack($this->request->get('points'));
        $stroke->save();
        return $stroke;
    }

    protected function cleanData(): void
    {
        $data = $this->request->except('shape');
        $this->shape->fill($data);
        $this->shape->shape = [];


        // Do the shape stuff
        $this->fillShape();
    }

    protected function fillShape(): void
    {
        $this->fill = $this->shape->shape;
        if ($this->shape->isRectangle()) {
            $this->colour();
        } elseif ($this->shape->isCircle()) {
            $this->colour();
        } elseif ($this->shape->isText()) {
            $this->colour()
                ->text();
        } elseif ($this->shape->isImage()) {
            $this->gallery();
        } elseif ($this->shape->isEntity()) {
            $this->entity()
            ->colour();
        } elseif ($this->shape->isDrawing()) {

        }
        $this->shape->shape = $this->fill;
    }

    protected function colour(): self
    {
        if ($this->request->filled('fill')) {
            $this->fill['fill'] = $this->request->get('fill');
        }
        return $this;
    }

    protected function text(): self
    {
        if ($this->request->filled('text')) {
            $this->fill['text'] = $this->request->get('text');
        }
        if ($this->request->filled('fontSize')) {
            $this->fill['fontSize'] = $this->request->get('fontSize');
        }
        return $this;
    }

    protected function gallery(): self
    {
        if ($this->request->filled('uuid')) {
            $this->fill['uuid'] = $this->request->get('uuid');
        }
        return $this;
    }

    protected function entity(): self
    {
        if ($this->request->filled('entity_id')) {
            $this->fill['entity_id'] = $this->request->get('entity_id');
        }
        return $this;
    }

    protected function points(): void
    {
        if (!$this->shape->isDrawing()) {
            return;
        }

        if (!$this->request->filled('children')) {
            return;
        }

        $children = $this->request->get('children');
        foreach ($children as $data) {
            $stroke = new WhiteboardStroke();
            $stroke->shape_id = $this->shape->id;
            $stroke->color = Arr::get($data, 'fill', '#cccccc');
            $stroke->width = Arr::get($data, 'strokeWidth', 1);
            $stroke->points = $this->pack($data['points']);
            $stroke->save();
        }
    }

    /**
     * Pack an array of points into a binary blob string
     */
    protected function pack(array $points, int $scale = 1000): string
    {
        $bin = '';
        $count = count($points);

        if ($count % 2 !== 0) {
            throw new InvalidArgumentException('Point array must have even length');
        }

        for ($i = 0; $i < $count; $i += 2) {
            $x = (int) round($points[$i]     * $scale);
            $y = (int) round($points[$i + 1] * $scale);

            $bin .= pack('q', $x);
            $bin .= pack('q', $y);
        }

        return $bin;
    }
}
