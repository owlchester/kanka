<?php

namespace App\Services\Whiteboards\Shapes;

use App\Models\Whiteboard;
use App\Models\WhiteboardShape;
use App\Traits\RequestAware;

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
}
