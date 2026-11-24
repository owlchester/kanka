<?php

namespace App\Datagrids\Sorters;

class QuestElementSorter
{
    private const string SESSION_KEY = 'dg-sorter-quest-element-sorter';

    private const array OPTIONS = [
        'entity.name' => 'crud.fields.name',
        'role' => 'quests.fields.role',
    ];

    private string $selected = '';

    private string $column = 'role';

    private string $order = 'asc';

    public function __construct()
    {
        $selected = session()->get(self::SESSION_KEY);
        if (is_string($selected)) {
            $this->parse($selected);
        }
    }

    public function options(): array
    {
        return self::OPTIONS;
    }

    public function isSelected(string $key, bool $asc = true): bool
    {
        return $this->selected === $key . $this->direction($asc);
    }

    public function direction(bool $asc = true): string
    {
        return $asc ? '_asc' : '_desc';
    }

    public function fieldname(): string
    {
        return 'dg-sort';
    }

    public function request(array $data): self
    {
        $selected = $data[$this->fieldname()] ?? null;
        if (is_string($selected) && str_contains($selected, '_')) {
            $this->parse(mb_strtolower($selected));
            session()->put(self::SESSION_KEY, $this->selected);
        }

        return $this;
    }

    public function column(): string
    {
        return $this->column;
    }

    public function order(): string
    {
        return $this->order;
    }

    private function parse(string $selected): void
    {
        $this->selected = $selected;
        $segments = explode('_', $selected);
        $order = array_pop($segments);
        $field = implode('_', $segments);
        if (array_key_exists($field, self::OPTIONS)) {
            $this->column = $field;
        }
        if (in_array($order, ['asc', 'desc'], true)) {
            $this->order = $order;
        }
    }
}
