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

    protected function cleanData(): void
    {
        $data = $this->request->except('shape');
        $this->shape->fill($data);
        $this->shape->shape = [];
    }
}
