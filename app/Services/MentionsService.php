<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\MiscModel;
use App\Traits\MentionTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class MentionsService
{
    use MentionTrait;

    protected $text = '';
    protected $entities = [];

    /**
     * Map the mentions in an entity
     * @param MiscModel $model
     * @param string $field
     * @return string
     */
    public function map(MiscModel $model, $field = 'entry'): string
    {
        $this->text = !empty($model->$field) ? $model->$field : '';
        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in an entity's tooltip (boosted feature)
     * @param Entity $entity
     * @param string $field
     * @return string
     */
    public function mapEntity(Entity $entity, $field = 'tooltip'): string
    {
        $this->text = !empty($entity->$field) ? $entity->$field : '';
        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in an entity note
     * @param EntityNote $entityNote
     * @return string|string[]|null
     */
    public function mapEntityNote(EntityNote $entityNote)
    {
        $this->text = $entityNote->entry;
        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in an entity note
     * @param EntityNote $entityNote
     * @return string|string[]|null
     */
    public function mapCampaign(Campaign $campaign, string $field = 'entry')
    {
        $this->text = $campaign->$field;
        return $this->extractAndReplace();
    }

    /**
     * Searche mentions in a text and replace them with tooltiped links
     * @return string|string[]|null
     */
    protected function extractAndReplace()
    {
        // Extract links from the entry to foreign
        $this->text = preg_replace_callback('`\[([a-z_]+):(.*?)\]`i' , function($matches) {
            $data = $this->extractData($matches);

            /** @var Entity $entity */
            $entity = $this->entity($data['id']);

            // No entity found, the user might not be allowed to see it
            if (empty($entity) || empty($entity->child)) {
                $replace = Arr::get($data, 'text', '<i>' . __('crud.history.unknown') . '</i>');
            } else {
                $tab = Arr::get($data, 'tab', null);
                $url = $entity->url('show', $tab);
                if (!empty($data['page'])) {
                    $url .= '/' . strip_tags(trim($data['page'], '/'));

                    // Let's validate this new url first. Maybe we need to map to entities/id (ex inventory)
                    $entityPages = ['inventory'];
                    if (in_array($data['page'], $entityPages)) {
                        $url = route('entities.' . $data['page'], $entity->id);
                    }
                }
                $replace = '<a href="' . $url . '"'
                    . ' data-toggle="tooltip-ajax"'
                    . ' data-id="' . $entity->id . '"'
                    . ' data-url="' . route('entities.tooltip', $entity). '"'
                    . '>'
                    . Arr::get($data, 'text', $entity->name)
                    . '</a>';
            }
            return $replace;
        }, $this->text);

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
}
