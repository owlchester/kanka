<?php

namespace App\Services;

use App\Facades\Attributes;
use App\Facades\Mentions;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\MiscModel;
use App\Traits\MentionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MentionsService
{
    use MentionTrait;

    /** @var string The text that is being parsed, usualy an entry field */
    protected string $text = '';

    /** @var array|Entity[] List of entities */
    protected array $entities = [];

    /** @var array|Attribute[] List of attributes */
    protected array $attributes = [];

    /** @var array List of mentioned entities (their ids) */
    protected array $mentionedEntities = [];

    /** @var array List of mentioned entity types (type_id) */
    protected array $mentionedEntityTypes = [];

    /** @var array List of mentioned attributes (their ids) */
    protected array $mentionedAttributes = [];

    /** @var array List of valid entity types */
    protected array $validEntityTypes = [];

    /** @var array Created new mentions to avoid duplicates */
    protected array $newEntityMentions = [];

    /** @var bool New entities have been created from the mention parsing */
    protected bool $createdNewEntities = false;

    /** @var string Class used to inject and strip advanced mention name helpers */
    public const ADVANCED_MENTION_CLASS = 'advanced-mention-name';

    /** @var EntityService */
    protected EntityService $entityService;

    /** @var bool When false, parsing field:entry won't render mentions */
    protected bool $enableEntryField = true;

    /**
     * Mentions Service constructor
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    /**
     * Map the mentions in an entity
     * @param MiscModel $model
     * @param string $field
     * @return string
     */
    public function map(MiscModel $model, string $field = 'entry'): string
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
    public function mapEntity(Entity $entity, string $field = 'tooltip'): string
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
        $this->text = (string) $entityNote->entry;
        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in any model
     * @param Model $model
     * @param string $field
     * @return string|string[]|null
     */
    public function mapAny(Model $model, string $field = 'entry')
    {
        $this->text = (string) $model->{$field};
        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in an attribute
     * @param Attribute $attribute
     * @return string|string[]|null
     */
    public function mapAttribute(Attribute $attribute)
    {
        $this->text = (string) $attribute->value;
        $attribute->value = $this->extractAndReplace();

        return Attributes::parse($attribute);
    }

    /**
     * If new entities were created from the mentions
     * @return bool
     */
    public function hasNewEntities(): bool
    {
        return $this->createdNewEntities;
    }

    /**
     * Parse a model's text for editing (transform mentions into advanced mentions, normal
     * mentions visually, etc)
     * @param Model $model
     * @param string $field
     * @return string
     */
    public function parseForEdit(Model $model, string $field = 'entry'): string
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
        // We have to cast to a string for when the entity was created in the API with a NULL entry
        $this->text = (string) $model->$field;
        return $this->replaceForEdit();
    }

    /**
     * Replace span mentions into [entity:123] blocks
     * @param $text
     * @return string
     */
    public function codify($text): string
    {
        if (empty($text)) {
            $text = '';
        }
        //dump($text);
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
            '`<a class="mention" href="#" data-name="(.*?)" data-mention="([^"]*)">(.*?)</a>`',
            '$2',
            $text
        );
        $text = preg_replace(
            '`<a class="mention" href="#" data-mention="([^"]*)">(.*?)</a>`',
            '$1',
            $text
        );

        // Summernote will inject the link differently.
        //dump($text);
        $text = preg_replace_callback(
            '`<a href="([^"]*)" class="mention" data-name="(.*?)" data-mention="([^"]*)">(.*?)</a>`',
            function ($data) {
                //dump($data);
                if (count($data) !== 5) {
                    return $data[0];
                }
                // If the name was changed, inject advanced mention
                if ($data[2] != $data[4]) {
                    return str_replace(']', '|' . $data[4] . ']', $data[3]);
                }
                return $data[3];
            },
            $text
        );
        //dd($text);

        // Attributes
        $text = preg_replace(
            '`<a href="#" class="attribute attribute-mention" data-attribute="([^"]*)">(.*?)</a>`',
            '$1',
            $text
        );
        $text = preg_replace(
            '`<a class="attribute attribute-mention" href="#" data-attribute="([^"]*)">(.*?)</a>`',
            '$1',
            $text
        );

        // Remove advanced mention name blocks
        //dump($text);
        $text = preg_replace(
            '`<span class="' . self::ADVANCED_MENTION_CLASS . '" data-name="([^"]*)"></span>`',
            null,
            $text
        );

        //dd($text);
        return $text;
    }

    /**
     * Parse an entity and create the advanced mention helper bubble
     * @param string $name
     * @return string
     */
    public function advancedMentionHelper(string $name): string
    {
        $cleanEntityName = Str::replace(['"'], ['\''], $name);
        return '<span class="' . self::ADVANCED_MENTION_CLASS . '" data-name="'
            . $cleanEntityName . '"></span>';
    }

    /**
     * Searche mentions in a text and replace them with tooltiped links
     * @return string|string[]|null
     */
    protected function extractAndReplace()
    {
        // First let's prepare all mentions to do a single query on the entities table
        $this->mentionedEntities = [];
        preg_replace_callback('`\[([a-z_]+):(.*?)\]`i', function ($matches) {
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
        $this->text = preg_replace_callback('`\[([a-z_]+):(.*?)\]`i', function ($matches) {
            // Icons
            $fontAwesomes = ['fa ', 'fas ', 'far ', 'fab ', 'ra ', 'fa-solid ', 'fa-regular ', 'fa-brands '];
            if ($matches[1] == 'icon' && Str::startsWith($matches[2], $fontAwesomes)) {
                return '<i class="' . e($matches[2]) . '"></i>';
            }

            $data = $this->extractData($matches);

            /** @var Entity $entity */
            $entity = $this->entity($data['id']);
            $tagClasses = [];
            $cssClasses = ['entity-mention'];

            // No entity found, the user might not be allowed to see it
            if (empty($entity) || empty($entity->child)) {
                $replace = Arr::get(
                    $data,
                    'text',
                    '<i class="unknown-mention unknown-entity">' . __('crud.history.unknown') . '</i>'
                );
            } else {
                $routeOptions = [];
                if (!empty($data['params'])) {
                    $routeParams = explode('&amp;', $data['params']);
                    foreach ($routeParams as $routeParam) {
                        // Do we whitelist? or have a max length to avoid shenanigans?
                        if (strlen($routeParam) > 20) {
                            continue;
                        }
                        $paramOptions = explode('=', $routeParam);
                        if (count($paramOptions) != 2) {
                            continue;
                        }
                        $routeOptions[$paramOptions[0]] = $paramOptions[1];
                    }
                }

                $url = $entity->url('show', $routeOptions);
                if (!empty($data['page'])) {
                    // Let's validate this new url first. Maybe we need to map to entities/id (ex inventory)
                    $entityPages = ['inventory', 'abilities', 'relations', 'attributes', 'assets'];
                    if (in_array($data['page'], $entityPages)) {
                        $page = $data['page'];
                        if ($page === 'relations') {
                            $page = 'relations.index';
                        } elseif ($page === 'assets') {
                            $page = 'entity_assets.index';
                        }
                        $url = route('entities.' . $page, array_merge([$entity->id], $routeOptions));
                    } else {
                        $url = $entity->url($data['page'], $routeOptions);
                    }
                }
                // An alias was used for this mention, so let's try and find it. ACL is handled directly
                // on the EntityAlias object.
                if (!empty($data['alias'])) {
                    $alias = $entity->assets()->alias()->where('id', $data['alias'])->first();
                    if (!empty($alias)) {
                        $data['text'] = $alias->name;
                    }
                }
                if (!empty($data['anchor'])) {
                    $url .= '#' . $data['anchor'];
                }

                $dataUrl = route('entities.tooltip', $entity);

                // If this request is through the API, we need to inject the language in the url
                if (request()->is('api/*')) {
                    $lang = request()->header('kanka-locale', auth()->user()->locale ?? 'en');
                    $url = Str::replaceFirst('campaign/', $lang . '/campaign/', $url);
                    $dataUrl = Str::replaceFirst('campaign/', $lang . '/campaign/', $dataUrl);
                }

                // Add tags as a class
                foreach ($entity->tags as $tag) {
                    $tagClasses[] = 'id-' . $tag->id;
                    $tagClasses[] = Str::slug($tag->name);
                }

                // Referencing a custom field on the entity
                if (!empty($data['field'])) {
                    $field = $data['field'];
                    // Mapping
                    if ($field == 'gender') {
                        $field = 'sex';
                    }
                    if ($field === 'entry') {
                        if ($this->enableEntryField) {
                            $this->lockEntryRendering();
                            $parsedTargetEntry = $entity->child->entry();
                            $this->unlockEntryRendering();
                        } else {
                            $parsedTargetEntry = $entity->child->entry;
                        }
                        $cssClasses[] = 'mention-field-entry';
                        $entityName = '<a href="' . $url . '"'
                            . ' class="entity-mention-name block mb-2"'
                            . ' data-toggle="tooltip-ajax"'
                            . ' data-id="' . $entity->id . '"'
                            . ' data-url="' . $dataUrl . '"'
                            . '>'
                            . Arr::get($data, 'text', $entity->name)
                            . '</a>';
                        ;
                        return '<div class="' . implode(' ', $cssClasses) . '"'
                            . ' data-entity-tags="' . implode(' ', $tagClasses) . '"'
                            . '>'
                            . $entityName
                            . $parsedTargetEntry
                            . '</div>';
                    } elseif (isset($entity->child->$field)) {
                        $foreign = $entity->child->$field;
                        if ($foreign instanceof Model) {
                            if (isset($foreign->name) && !empty($foreign->name)) {
                                $data['text'] = $foreign->name;
                            }
                        } elseif (is_string($foreign)) {
                            $data['text'] = $foreign;
                        }
                    } elseif (isset($entity->$field) && is_string($entity->$field)) {
                        $data['text'] = $entity->$field;
                    }

                    $cssClasses[] = 'mention-field-' . Str::slug($field);
                }

                $replace = '<a href="' . $url . '"'
                    . ' class="' . implode(' ', $cssClasses) . '"'
                    . ' data-entity-tags="' . implode(' ', $tagClasses) . '"'
                    . ' data-toggle="tooltip-ajax"'
                    . ' data-id="' . $entity->id . '"'
                    . ' data-url="' . $dataUrl . '"'
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

        // Can't forget our custom blocks
        $this->mapCodes();

        // Clean up weird ` chars that break the js
        $this->text = str_replace('`', '\'', $this->text);

        return $this->text;
    }

    /**
     * @return string
     */
    protected function replaceForEdit(): string
    {
        // Extract links from the entry to foreign
        $this
            ->parseMentionsForEdit()
            ->parseAttributesForEdit();

        return (string) $this->text;
    }

    /**
     * Replace mentions of entities to a visual representation for the text editor
     * @return $this
     */
    protected function parseMentionsForEdit(): self
    {
        $this->text = preg_replace_callback('`\[([a-z_]+):(.*?)\]`i', function ($matches) {
            $data = $this->extractData($matches);

            $hasCustom = Arr::has($data, 'custom');

            // If the user always wants advanced mentions, we force the [] syntax upon them
            if ($hasCustom || auth()->user()->alwaysAdvancedMentions()) {
                // Still need to show the target's name in the advanced mention
                $entity = $this->entity($data['id']);
                if (empty($entity) || empty($entity->child)) {
                    return $matches[0];
                }

                $advancedName = $this->advancedMentionHelper($entity->name);
                return Str::replaceLast(']', $advancedName . ']', $matches[0]);
            }

            // This was matched on an attribute
            if ($data['type'] == 'icon') {
                return $matches[0];
            }

            $entity = $this->entity($data['id']);

            // No entity found, the user might not be allowed to see it
            if (empty($entity) || empty($entity->child)) {
                $name = __('crud.history.unknown');
            } else {
                $name = $entity->name;
            }
            return '<a href="#" class="mention" data-name="' . $name . '" data-mention="' . $matches[0]
                . '">' . $name . '</a>';
        }, $this->text);

        return $this;
    }

    /**
     * Replace mentions of attributes to a visual representation for the text editor
     * @return $this
     */
    protected function parseAttributesForEdit(): self
    {
        // If the user has advanced mentions always on, don't replace attributes
        if (auth()->user()->alwaysAdvancedMentions()) {
            return $this;
        }
        // Extract links from the entry to attribute
        $this->text = preg_replace_callback('`\{attribute:(.*?)\}`i', function ($matches) {
            $id = (int) $matches[1];

            /** @var Entity $entity */
            $attribute = $this->attribute($id);

            // No entity found, the user might not be allowed to see it
            if (empty($attribute)) {
                $name = __('crud.history.unknown');
            } else {
                $name = $attribute->name;
            }
            return '<a href="#" class="attribute attribute-mention" data-attribute="' . $matches[0]
                . '">{' . $name . '}</a>';
        }, $this->text);

        return $this;
    }

    /**
     * @param int $id
     * @return Entity
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
        $entities = Entity::whereIn('id', $ids)->with('tags:id,name')->get();
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
        preg_replace_callback('`\{attribute:(.*?)\}`i', function ($matches) {
            $id = (int) $matches[1];
            if (!in_array($id, $this->mentionedAttributes)) {
                $this->mentionedAttributes[] = $id;
            }
        }, $this->text);

        // Pre-fetch all the entities
        $this->prepareAttributes();

        // Extract links from the entry to foreign
        $this->text = preg_replace_callback('`\{attribute:(.*?)\}`i', function ($matches) {
            $id = (int) $matches[1];

            /** @var Attribute $attribute */
            $attribute = $this->attribute($id);

            // No entity found, the user might not be allowed to see it
            if (empty($attribute)) {
                $replace = '<i class="unknown-mention unknown-attribute">' . __('crud.history.unknown') . '</i>';
            } else {
                $replace = '<span class="attribute attribute-mention" title="' . e($attribute->name)
                    . '" data-toggle="tooltip">' . $attribute->mappedValue() . '</span>';
            }
            return $replace;
        }, $this->text);
    }

    protected function mapCodes()
    {
        if (Str::contains($this->text, '{table-of-contents}')) {
            $markupFixer  = new \TOC\MarkupFixer();
            $tocGenerator = new \TOC\TocGenerator();

            $this->text = $markupFixer->fix($this->text);
            $toc = $tocGenerator->getHtmlMenu($this->text);
            $this->text = Str::replaceFirst(
                '{table-of-contents}',
                '<div class="toc">' . $toc .  "</div>\n",
                $this->text
            );
        }
    }

    /**
     * Replace new entity mentions with entities.
     * @param string $type
     * @param string $name
     * @return string
     */
    protected function newEntityMention(string $type, string $name): string
    {
        if (empty($type) || empty($name)) {
            return $name;
        }

        $types = $this->entityService->newEntityTypes();

        // Invalid type
        if (!isset($types[$type])) {
            return $name;
        }

        // Do we already have it cached?
        $key = $type . ':' . strtolower($name);
        if (isset($this->newEntityMentions[$key])) {
            return "[$type:" . $this->newEntityMentions[$key] . ']';
        }

        // Check that the campaign can still accommodate more entities
        /*$campaign = \App\Facades\CampaignLocalization::getCampaign();
        if (!$campaign->canHaveMoreEntities()) {
            return $name;
        }*/

        // Create the new misc  model
        /** @var MiscModel $newMisc */
        $newMisc = new $types[$type]();

        $new = $this->entityService->makeNewMentionEntity($newMisc, $name);
        $this->newEntityMentions[$key] = $new->entity->id;
        $this->createdNewEntities = true;

        return '[' . $type . ':' . $new->entity->id . ']';
    }

    /**
     * Protect from rendering future field:entry mentions to avoid endless loops
     * @return void
     */
    protected function lockEntryRendering(): void
    {
        $this->enableEntryField = false;
    }

    /**
     * Re-enable rendering field:entry mentions
     * @return void
     */
    protected function unlockEntryRendering(): void
    {
        $this->enableEntryField = true;
    }
}
