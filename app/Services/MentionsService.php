<?php

namespace App\Services;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Traits\MentionTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MentionsService
{
    use MentionTrait;

    protected $text = '';
    protected $entities = [];

    /**
     * @param MiscModel $model
     * @param string $field
     * @return string
     */
    public function map(MiscModel $model, $field = 'entry'): string
    {
        $this->text = !empty($model->$field) ? $model->$field : '';

        $mappings = $this->extract($this->text);

        foreach ($mappings as $text => $data) {
            /** @var Entity $entity */
            $entity = $this->entity($data['id']);
            // No entity found, the user might not be allowed to see it
            if (empty($entity) || empty($entity->child)) {
                //$this->replace($text, $data, __('Unknown'));
                $replace = Arr::get($data, 'text', '<i>' . __('crud.history.unknown') . '</i>');
            } else {
                //$this->replace($text, $data, $entity);
                $tab = Arr::get($data, 'tab', null);
                $url = $entity->url('show', $tab);
                if (!empty($data['page']) && strlen($data['page']) < 8) {
                    $url .= '/' . strip_tags(trim($data['page'], '/'));
                }
                $replace = '<a href="' . $url . '"'
                    . ' data-toggle="tooltip-ajax"'
                    . ' data-id="' . $entity->id . '"'
                    . ' data-url="' . route('entities.tooltip', $entity). '"'
                    . '>'
                    . Arr::get($data, 'text', $entity->name)
                . '</a>';
            }

            $search = '`\[' . $data['type'] . ':' . $data['id'] . '([^\]]*?)\]`i';
            $this->text = preg_replace($search, $replace, $this->text);
        }

        return $this->text;
    }

    /**
     * @param int $id
     * @return mixed
     */
    protected function entity(int $id)
    {
        if (!Arr::has($this->entities, $id)) {
            $this->entities[$id] = Entity::where(['id' => $id])->first();
        }

        return Arr::get($this->entities, $id, null);
    }

    /**
     * @param string $lookup
     * @param string $replace
     * @param string $text
     * @return string
     */
    protected function replace(string $lookup, string $replace, string $text): string
    {
        return $text;
    }
}
