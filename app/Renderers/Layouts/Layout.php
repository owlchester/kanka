<?php

namespace App\Renderers\Layouts;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use Illuminate\Database\Eloquent\Model;

abstract class Layout
{
    use CampaignAware;

    public const ONLY_DESKTOP = 'hidden lg:table-cell';

    public const ACTION_EDIT = 'edit';

    public const ACTION_EDIT_DIALOG = 'edit-dialog';

    public const ACTION_DELETE = 'delete';

    public const ACTION_COPY = 'copy';

    /** @var bool|array */
    protected $visibleColumns = false;

    public function columns(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [];
    }

    public function bulks(): array
    {
        return [];
    }

    public function visibleColumns(): array
    {
        if ($this->visibleColumns !== false) {
            return $this->visibleColumns;
        }

        $this->visibleColumns = [];
        foreach ($this->columns() as $key => $column) {
            if (! isset($column['visible'])) {
                $this->visibleColumns[] = $column;

                continue;
            }
            $condition = $column['visible']();
            if (! $condition) {
                continue;
            }
            $this->visibleColumns[] = $column;
        }

        return $this->visibleColumns;
    }

    protected function entityLink(Model|MiscModel|Entity $model): string
    {
        if ($model instanceof Entity) {
            return \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($model, $this->campaign)
            );
        }

        // @phpstan-ignore-next-line
        return '<a href="' . $model->getLink() . '" class="text-link">' . $model->name . '</a>';
    }
}
