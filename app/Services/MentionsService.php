<?php

namespace App\Services;

use App\Facades\Attributes;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\MiscModel;
use App\Traits\MentionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class MentionsService
{
    use MentionTrait;

    protected $text = '';
    protected $entities = [];
    protected $attributes = [];

    /**
     * @var array
     */
    protected $mentionedEntities = [];
    protected $mentionedEntityTypes = [];
    protected $mentionedAttributes = [];

    /** @var array */
    protected $validEntityTypes = [];

    /** @var array Created new mentions to avoid duplicates */
    protected $newEntityMentions = [];

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
     * Map the mentions in any model
     * @param EntityNote $entityNote
     * @return string|string[]|null
     */
    public function mapAny(Model $model, string $field = 'entry')
    {
        $this->text = $model->{$field};
        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in an attribute
     * @param Attribute $attribute
     * @return string|string[]|null
     */
    public function mapAttribute(Attribute $attribute)
    {
        $this->text = e($attribute->value);
        $attribute->value = $this->extractAndReplace();

        return Attributes::parse($attribute);
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
     * @param MiscModel $model
     * @param string $field
     * @return string|string[]|null
     */
    public function edit(MiscModel $model, string $field = 'entry')
    {
        return $this->editEntity($model, $field);
    }
    public function editEntityNote(EntityNote $entityNote, string $field = 'entry')
    {
        return $this->editEntity($entityNote, $field);
    }
    public function editMisc(MiscModel $model, string $field = 'entry')
    {
        return $this->editEntity($model, $field);
    }
    public function editCampaign(Campaign $campaign, string $field = 'entry')
    {
        return $this->editEntity($campaign, $field);
    }
    public function editAny(Model $model, string $field = 'entry')
    {
        return $this->editEntity($model, $field);
    }

    /**
     * @param $model
     * @param string $field
     * @return string
     */
    protected function editEntity($model, string $field): string
    {
        // Advance mode will send back the "codes"
        if (Auth::user()->advancedMentions) {
            return (string) $model->$field;
        }

        // Standard more we want to remap mentions
        $this->text = $model->$field;
        return $this->replaceForEdit();
    }

    /**
     * Replace span mentions into [entity:123] blocks
     * @param string $text
     * @return string
     */
    public function codify($text): string
    {
        if (empty($text)) {
            $text = '';
        }
        // New entities
        $text = preg_replace_callback(
            '`\[new:([a-z_]+)\|(.*?)\]`i',
            function ($data) {
                if (count($data) !== 3) {
                    return $data[0];
                }
                // check type is valid
                return $this->newEntityMention($data[1], $data[2]);
            },
            $text
        );

        // TinyMCE mentions
        $text = preg_replace(
            '`<a class="mention" href="#" data-mention="([^"]*)">(.*?)</a>`',
            '$1',
            $text
        );

        // Summernote will inject the link differently
        $text = preg_replace(
            '`<a href="#" class="mention" data-mention="([^"]*)">(.*?)</a>`',
            '$1',
            $text
        );

        // Attributes
        $text = preg_replace(
            '`<a href="#" class="attribute" data-attribute="([^"]*)">(.*?)</a>`',
            '$1',
            $text
        );
        $text = preg_replace(
            '`<a class="attribute" href="#" data-attribute="([^"]*)">(.*?)</a>`',
            '$1',
            $text
        );

        return $text;
    }

    /**
     * Searche mentions in a text and replace them with tooltiped links
     * @return string|string[]|null
     */
    protected function extractAndReplace()
    {
        // First let's prepare all mentions to do a single query on the entities table
        $this->mentionedEntities = [];
        preg_replace_callback('`\[([a-z_]+):(.*?)\]`i' , function($matches) {
            $segments = explode('|', $matches[2]);
            $id = (int) $segments[0];
            $entityType = $matches[1];
            if (!in_array($id, $this->mentionedEntities)) {
                $this->mentionedEntities[] = $id;
            }
            // If the mentioned entity wasn't there yet, but the map also doesn't map to "entity"
            if (!in_array($matches[1], $this->mentionedEntityTypes) && $this->validEntityType($entityType)) {
                if ($matches[1] == 'attribute_template') {
                    $matches[1] = 'attributeTemplate';
                } elseif ($matches[1] == 'dice_roll') {
                    $matches[1] = 'diceRoll';
                }
                $this->mentionedEntityTypes[] = $matches[1];
            }
        }, $this->text);

        // Pre-fetch all the entities
        $this->prepareEntities();

        // Extract links from the entry to foreign
        $this->text = preg_replace_callback('`\[([a-z_]+):(.*?)\]`i' , function($matches) {
            $data = $this->extractData($matches);

            /** @var Entity $entity */
            $entity = $this->entity($data['id']);

            // No entity found, the user might not be allowed to see it
            if (empty($entity) || empty($entity->child)) {
                $replace = Arr::get($data, 'text', '<i class="unknown-mention unknown-entity">' . __('crud.history.unknown') . '</i>');
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
//                    . ' data-mention-url="' . route('entities.tooltip', $entity). '"'
//                    . ' title="<i class=\'fa fa-spinner fa-spin\'></i>"'
                    . '>'
                    . Arr::get($data, 'text', $entity->name)
                    . '</a>';
            }
            return $replace;
        }, $this->text);

        // And now for extra fun, let's do attributes!
        $this->mapAttributes();

        // Clean up weird ` chars that break the js
        $this->text = str_replace('`', '\'', $this->text);

        return $this->text;
    }

    /**
     * @return string|string[]|null
     */
    protected function replaceForEdit()
    {
        // Extract links from the entry to foreign
        $this->text = preg_replace_callback('`\[([a-z_]+):(.*?)\]`i' , function($matches) {
            $data = $this->extractData($matches);

            $hasCustom = Arr::has($data, 'custom');
            if ($hasCustom) {
                return $matches[0];
            }

            /** @var Entity $entity */
            $entity = $this->entity($data['id']);

            // No entity found, the user might not be allowed to see it
            if (empty($entity) || empty($entity->child)) {
                $name = __('crud.history.unknown');
            } else {
                $name = $entity->name;
            }
            return '<a href="#" class="mention" data-mention="' . $matches[0] . '">' . $name . '</a>';
        }, $this->text);

        // Extract links from the entry to attribute
        $this->text = preg_replace_callback('`\{attribute:(.*?)\}`i' , function($matches) {
            $id = (int) $matches[1];

            /** @var Entity $entity */
            $attribute = $this->attribute($id);

            // No entity found, the user might not be allowed to see it
            if (empty($attribute)) {
                $name = __('crud.history.unknown');
            } else {
                $name = $attribute->name;
            }
            return '<a href="#" class="attribute" data-attribute="' . $matches[0] . '">{' . $name . '}</a>';
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

    /**
     * @param int $id
     * @return mixed
     */
    protected function attribute(int $id)
    {
        if (!Arr::has($this->attributes, $id)) {
            $this->attributes[$id] = Attribute::where(['id' => $id])->first();
        }

        return Arr::get($this->attributes, $id, null);
    }

    /**
     * Pre-fetch all mentioned entities
     */
    protected function prepareEntities()
    {
        // Remove those already cached in memory
        $ids = [];
        foreach ($this->mentionedEntities as $id) {
            if (!Arr::has($this->entities, $id)) {
                $ids[] = $id;
            }
        }

        if (empty($ids)) {
            return;
        }

        // Directly get with the mentioned entity types (provided they are valid)
        $entities = Entity::whereIn('id', $ids)->with($this->mentionedEntityTypes)->get();
        foreach ($entities as $entity) {
            $this->entities[$entity->id] = $entity;
        }
    }

    /**
     * Pre fetch the attributes of the entity
     */
    protected function prepareAttributes()
    {
        // Remove those already cached in memory
        $ids = [];
        foreach ($this->mentionedAttributes as $id) {
            if (!Arr::has($this->attributes, $id)) {
                $ids[] = $id;
            }
        }

        if (empty($ids)) {
            return;
        }

        $attributes = Attribute::whereIn('id', $ids)->get();
        foreach ($attributes as $attribute) {
            $this->attributes[$attribute->id] = $attribute;
        }
    }

    /**
     * Validate the entity type that was inserted in the mention block
     * @param string $type
     * @return bool
     */
    protected function validEntityType(string $type): bool
    {
        return in_array($type, $this->validEntityTypes());
    }

    /**
     * List of valid entity types
     * @return array
     */
    protected function validEntityTypes(): array
    {
        if (!empty($this->validEntityTypes)) {
            return $this->validEntityTypes;
        }

        $validEntityTypes = array_keys(config('entities.ids'));
        return $this->validEntityTypes = $validEntityTypes;
    }

    /**
     * Replace all attributes with their values and a toolip
     */
    protected function mapAttributes()
    {
        $this->mentionedAttributes = [];
        preg_replace_callback('`\{attribute:(.*?)\}`i' , function($matches) {
            $id = (int) $matches[1];
            if (!in_array($id, $this->mentionedAttributes)) {
                $this->mentionedAttributes[] = $id;
            }
        }, $this->text);

        // Pre-fetch all the entities
        $this->prepareAttributes();

        // Extract links from the entry to foreign
        $this->text = preg_replace_callback('`\{attribute:(.*?)\}`i' , function($matches) {
            $id = (int) $matches[1];

            /** @var Attribute $attribute */
            $attribute = $this->attribute($id);

            // No entity found, the user might not be allowed to see it
            if (empty($attribute)) {
                $replace = '<i class="unknown-mention unknown-attribute">' . __('crud.history.unknown') . '</i>';
            } else {
                $replace = '<span class="attribute" title="' . e($attribute->name) . '" data-toggle="tooltip">' . $attribute->mappedValue() . '</span>';
            }
            return $replace;
        }, $this->text);
    }

    /**
     * Replace new entity mentions with entities.
     * @param $data
     * @return string
     */
    protected function newEntityMention(string $type, string $name): string
    {
        if (empty($type) || empty($name)) {
            return (string) $name;
        }

        /** @var EntityService $service */
        $service = app()->make(EntityService::class);
        $types = $service->newEntityTypes();

        // Invalid type
        if (!isset($types[$type])) {
            return (string) $name;
        }

        // Do we already have it cached?
        $key = $type . ':' . strtolower($name);
        if (isset($this->newEntityMentions[$key])) {
            return "[$type:" . $this->newEntityMentions[$key] . ']';
        }

        // Create the new misc  model
        /** @var MiscModel $newMisc */
        $newMisc = new $types[$type]();

        $new = $service->makeNewMentionEntity($newMisc, $name);
        $this->newEntityMentions[$key] = $new->entity->id;

        return '[' . $type . ':' . $new->entity->id . ']';

    }
}
