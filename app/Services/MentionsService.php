<?php

namespace App\Services;

use App\Facades\Attributes;
use App\Facades\CampaignLocalization;
use App\Facades\Domain;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\Map;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\Quest;
use App\Services\Entity\NewService;
use App\Services\TOC\TocSlugify;
use App\Traits\CampaignAware;
use App\Traits\MentionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use TOC\MarkupFixer;

class MentionsService
{
    use CampaignAware;
    use MentionTrait;

    /** The text that is being parsed, usually an entry field */
    protected ?string $text = '';

    /** @var array|Entity[] List of entities */
    protected array $entities = [];

    /** @var array|Post[] List of posts */
    protected array $posts = [];

    /** @var array|Entity[] List of private entities */
    protected array $privateEntities = [];

    /** @var array|EntityAsset[] List of entity aliases */
    protected array $aliases = [];

    /** @var array|Attribute[] List of attributes */
    protected array $attributes = [];

    /** @var array List of mentioned entities (their ids) */
    protected array $mentionedEntities = [];

    /** @var array List of mentioned private entities (their ids) */
    protected array $hiddenEntities = [];

    /** @var array List of mentioned attributes (their ids) */
    protected array $mentionedAttributes = [];

    /** @var array List of valid entity types */
    protected array $validEntityTypes = [];

    /** @var string Class used to inject and strip advanced mention name helpers */
    public const string ADVANCED_MENTION_CLASS = 'advanced-mention-name';

    /** @var bool When false, parsing field:entry won't render mentions */
    protected bool $enableEntryField = true;

    /** @var bool When true, names of entities will be rendered, instead of a tooltip link */
    protected bool $onlyName = false;

    /** @var bool When true, mentions will be mapped into links to the entities */
    protected bool $isCopying = false;

    public function __construct(
        protected MarkupFixer $markupFixer,
        protected NewService $newService,
    ) {}

    /**
     * Map the mentions in an entity
     */
    public function map(MiscModel $model, string $field = 'entry'): string
    {
        $this->text = ! empty($model->$field) ? $model->$field : '';

        return $this->extractAndReplace();
    }

    /**
     * Map a string
     */
    public function mapText(?string $text = null): string
    {
        $this->text = $text;

        return $this->extractAndReplace();
    }

    /**
     * Map a string
     */
    public function mapCopiedEntry(?string $text = null): string
    {
        $this->text = $text;

        return $this->extractAndLink();
    }

    /**
     * Map the mentions in an entity's tooltip (boosted feature)
     */
    public function mapEntity(Entity $entity, string $field = 'tooltip'): string
    {
        $this->text = ! empty($entity->$field) ? $entity->$field : '';

        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in any model
     *
     * @return string|string[]|null
     */
    public function mapAny(Model $model, string $field = 'entry')
    {
        $this->text = (string) $model->{$field};

        return $this->extractAndReplace();
    }

    /**
     * Map the mentions in an attribute
     *
     * @return string|string[]|null
     */
    public function mapAttribute(Attribute $attribute, ?string $text = null)
    {
        // If the attribute mentions itself in the value, don't do any parsing, it would cause an endless loop.
        // The first check is for unchecked checkboxes
        if (! empty($attribute->value) && Str::contains($attribute->value, $attribute->mentionName())) {
            return Attributes::parse($attribute);
        }

        // Called in this order to avoid a bug that would render an attribute mention inside an attribute wrong.
        if (! $text) {
            $this->text = Attributes::parse($attribute);
        } else {
            $this->text = $text;
        }

        return $this->extractAndReplace();
    }

    public function onlyName(bool $option = true): self
    {
        $this->onlyName = $option;

        return $this;
    }

    /**
     * Parse a model's text for editing (transform mentions into advanced mentions, normal
     * mentions visually, etc)
     */
    public function parseForEdit(Model $model, string $field = 'entry'): string
    {
        return $this->editEntity($model, $field);
    }

    protected function editEntity(Model $model, string $field): string
    {
        // We have to cast to a string for when the entity was created in the API with a NULL entry
        $this->text = (string) $model->$field;

        return $this->replaceForEdit();
    }

    /**
     * Parse an entity and create the advanced mention helper bubble
     */
    public function advancedMentionHelper(string $name): string
    {
        $cleanEntityName = Str::replace(['"', '&amp;'], ['\'', '&'], $name);

        return '<ins class="' . self::ADVANCED_MENTION_CLASS . '" data-name="'
            . $cleanEntityName . '"></ins>';
    }

    /**
     * Search mentions in a text and replace them with tooltiped links
     *
     * @return string|string[]|null
     */
    protected function extractAndReplace()
    {
        // Pre-fetch all the entities
        $this->prepareEntities();
        $this->prepareHiddenEntities();

        // Extract links from the entry to foreign
        $this->replaceEntityMentions();

        // And now for extra fun, let's do attributes!
        $this->mapAttributes();

        // Can't forget our custom blocks
        $this->mapCodes();

        // Clean up weird ` chars that break the js
        $this->text = str_replace('`', '\'', $this->text);

        $this->fixGalleryUrls();

        return $this->text;
    }

    public function extractAndLink(): string
    {
        CampaignLocalization::forceCampaign($this->campaign);

        $this->isCopying = true;
        // Pre-fetch all the entities
        $this->prepareEntities();
        $this->prepareHiddenEntities();

        // Extract links from the entry to foreign
        $this->replaceEntityMentions();

        return $this->text;
    }

    protected function replaceEntityMentions(): void
    {
        $this->text = preg_replace_callback('`\[([a-z_-]+):(.*?)\]`i', function ($matches) {
            // Icons
            $fontAwesomes = ['fa ', 'fas ', 'far ', 'fab ', 'ra ', 'fa-solid ', 'fa-regular ', 'fa-brands '];
            if ($matches[1] == 'icon' && Str::startsWith($matches[2], $fontAwesomes)) {
                return '<i class="' . e($matches[2]) . '" aria-hidden="true"></i>';
            }

            $data = $this->extractData($matches);
            if (Arr::get($data, 'type') === 'post') {
                return $this->mentionPost($data);
            }

            $entity = $this->entity($data['id']);
            $tagClasses = [];
            $cssClasses = ['entity-mention'];
            // No entity found, the user might not be allowed to see it
            if (empty($entity)) {
                $hiddenEntity = $this->hiddenEntity($data['id']);
                if (empty($hiddenEntity)) {
                    if ($this->onlyName) {
                        return __('crud.history.unknown');
                    }
                    $replace = Arr::get(
                        $data,
                        'text',
                        '<i class="unknown-mention unknown-entity">' . __('crud.history.unknown') . '</i>'
                    );
                } else {
                    // An alias was used for this mention, so let's try and find it. ACL is handled directly
                    // on the EntityAlias object.
                    if (! empty($data['alias'])) {
                        $alias = $hiddenEntity->assets()->alias()->where('id', $data['alias'])->first();
                        if (! empty($alias)) {
                            $data['text'] = $alias->name;
                        }
                    }
                    if ($this->onlyName) {
                        return Arr::get($data, 'text', $hiddenEntity->name);
                    }
                    $replace = '<i class="unknown-mention unknown-entity" data-entity-type="' .
                        $hiddenEntity->entityType->code . '">' .
                        Arr::get($data, 'text', $hiddenEntity->name) . '</i>';
                }
            } else {
                $routeOptions = [];
                if (! empty($data['params'])) {
                    $routeParams = explode('&amp;', $data['params']);
                    foreach ($routeParams as $routeParam) {
                        // Do we whitelist? or have a max length to avoid shenanigans?
                        if (mb_strlen($routeParam) > 20) {
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
                if (! empty($data['page'])) {
                    // Let's validate this new url first. Maybe we need to map to entities/id (ex inventory)
                    $entityPages = ['inventory', 'abilities', 'relations', 'attributes', 'assets'];
                    if (in_array($data['page'], $entityPages)) {
                        $page = $data['page'];
                        if ($page === 'relations') {
                            $page = 'relations.index';
                        } elseif ($page === 'assets') {
                            $page = 'entity_assets.index';
                        }
                        $url = route('entities.' . $page, [$this->campaign, $entity->id] + $routeOptions);
                    } else {
                        $url = $entity->url($data['page'], [$this->campaign] + $routeOptions);
                    }
                }
                // An alias was used for this mention, so let's try and find it. ACL is handled directly
                // on the EntityAlias object.
                if (! empty($data['alias'])) {
                    $alias = $entity->assets()->alias()->where('id', $data['alias'])->first();
                    if (! empty($alias)) {
                        $data['text'] = $alias->name;
                    }
                }
                if (! empty($data['anchor'])) {
                    $url .= '#' . $data['anchor'];
                }

                $dataUrl = route('entities.tooltip', [$this->campaign, $entity]);
                if (! empty($data['tooltip']) && $data['tooltip'] === 'attributes') {
                    $dataUrl = route('entities.tooltip', [$this->campaign, $entity, 'render' => 'attributes']);
                }

                // If this request is through the API, we need to inject the language in the url
                if (request()->is('api/*') || Domain::isApi()) {
                    $url = Str::replaceFirst('/campaign/', '/w/', $url);
                    $dataUrl = Str::replaceFirst('/w/', '/w/', $dataUrl);
                }

                // Add tags as a class
                foreach ($entity->tags as $tag) {
                    $tagClasses[] = 'id-' . $tag->id;
                    $tagClasses[] = $tag->slug;
                }
                // Referencing a custom field on the entity
                if (! empty($data['field'])) {
                    $field = $data['field'];
                    // Mapping
                    if ($field == 'gender') {
                        $field = 'sex';
                    }

                    if (! $entity->isMissingChild()) {
                        /** @var Character|Map|Quest $child */
                        $child = $entity->child;
                        if ($field == 'family' && ! $child->families->isEmpty()) {
                            $data['text'] = $child->characterFamilies()->first()->family->name;
                        }
                        if ($field == 'race' && ! $child->characterRaces->isEmpty()) {
                            $data['text'] = $child->characterRaces->first()->race->name;
                        }
                        if ($field == 'calendar_date' && $child->calendar_id) {
                            $data['text'] = $child->calendarReminder()->readableDate();
                        }
                    }
                    if ($field === 'entry' && method_exists($entity, 'parsedEntry')) {
                        if ($this->enableEntryField) {
                            $this->lockEntryRendering();
                            $parsedTargetEntry = $entity->parsedEntry();
                            $this->unlockEntryRendering();
                        } else {
                            $parsedTargetEntry = $entity->entry;
                        }
                        $cssClasses[] = 'mention-field-entry block';
                        $entityName = '<a href="' . $url . '"'
                            . ' class="entity-mention-name block mb-2"'
                            . ' data-toggle="tooltip-ajax"'
                            . ' data-id="' . $entity->id . '"'
                            . ' data-url="' . $dataUrl . '"'
                            . '>'
                            . Arr::get($data, 'text', $entity->name)
                            . '</a>';

                        return '<span class="' . implode(' ', $cssClasses) . '"'
                            . ' data-entity-tags="' . implode(' ', $tagClasses) . '"'
                            . '>'
                            . $entityName
                            . '<div class="mention-entry-content">'
                            . $parsedTargetEntry
                            . '</div>'
                            . '</span>';
                    } elseif ($field === 'attributes') {
                        return '<iframe
                            src="' . route('entities.attributes-dashboard', [$this->campaign, $entity]) . '"
                            data-entity-tags="' . implode(' ', $tagClasses) . '"
                            data-entity-type="' . $entity->entityType->code . '"
                            class="entity-attributes-render w-full h-full"
                        ></iframe>';
                    } elseif ($field == 'map' && isset($child) && $child->explorable()) {
                        $height = 300;
                        $width = 300;
                        if (isset($routeOptions['height']) && is_numeric($routeOptions['height'])) {
                            $height = $routeOptions['height'];
                        }
                        if (isset($routeOptions['width']) && is_numeric($routeOptions['width'])) {
                            $width = $routeOptions['width'];
                        }

                        return '<iframe src="' . route('maps.preview', [$this->campaign, $child]) . '" class="map-preview" data-map="{{ $entity->id }}" width="' . $width . '" height="' . $height . '"></iframe>';
                    } elseif (! $entity->isMissingChild() && isset($entity->child->$field)) {
                        $foreign = $entity->child->$field;
                        if ($foreign instanceof Model) {
                            if (isset($foreign->name) && ! empty($foreign->name)) {
                                $data['text'] = $foreign->name;
                            }
                        } elseif (is_string($foreign)) {
                            $data['text'] = $foreign;
                        }
                        if ($field == 'date' && $entity->child instanceof \App\Models\Calendar) {
                            $data['text'] = $entity->child->niceDate();
                        }
                    } elseif (isset($entity->$field) && is_string($entity->$field)) {
                        $data['text'] = $entity->$field;
                    }

                    $cssClasses[] = 'mention-field-' . Str::slug($field);
                }

                if ($this->onlyName) {
                    return Arr::get($data, 'text', $entity->name);
                }

                if ($this->isCopying) {
                    return '<a href="' . $url . '" class="external-mention" data-entity-type="' . $entity->entityType->code . '"'
                    . '>'
                    . Arr::get($data, 'text', $entity->name)
                    . '</a>';
                }
                $replace = '<a href="' . $url . '"'
                    . ' class="' . implode(' ', $cssClasses) . '"'
                    . ' data-entity-tags="' . implode(' ', $tagClasses) . '"'
                    . ' data-entity-type="' . $entity->entityType->code . '"'
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
    }

    /**
     * The gallery injects images as a thumbnail, instead of the final URL.
     * Meaning that when we switched from images.kanka.io to th.kanka.io,
     * all the gallery images in text were broken.
     */
    protected function fixGalleryUrls(): self
    {
        if (empty(config('thumbor.key'))) {
            return $this;
        }
        $this->text = Str::replace(
            'https://images.kanka.io/user/',
            config('thumbor.url'),
            $this->text
        );

        return $this;
    }

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
     */
    protected function parseMentionsForEdit(): self
    {
        $this->text = preg_replace_callback('`\[([a-z_-]+):(.*?)\]`i', function ($matches) {
            $data = $this->extractData($matches);

            if ($data['type'] === 'post') {
                return $this->parsePostForEdit($matches[0], $data);
            }

            $hasCustom = Arr::has($data, 'custom');
            // If the user always wants advanced mentions, we force the [] syntax upon them
            if ($hasCustom || auth()->user()->alwaysAdvancedMentions()) {
                // Still need to show the target's name in the advanced mention
                $entity = $this->entity($data['id']);
                if (empty($entity) || $entity->isMissingChild()) {
                    return $matches[0];
                }

                $advancedName = $this->advancedMentionHelper($entity->name);
                if (! Arr::has($data, 'alias')) {
                    return Str::replaceLast(']', $advancedName . ']', $matches[0]);
                }

                // An alias was attached, try loading that too
                $alias = $this->alias($data['alias']);
                if (empty($alias) || empty($alias->entity)) {
                    return Str::replaceLast(']', $advancedName . ']', $matches[0]);
                }
                $aliasName = $this->advancedMentionHelper($alias->name);

                $mention = Str::replaceLast(']', $aliasName . ']', $matches[0]);
                $replaceId = ':' . $data['id'] . '|';

                return Str::replaceFirst($replaceId, ':' . $data['id'] . $advancedName . '|', $mention);
            }

            // This was matched on an attribute
            if ($data['type'] == 'icon') {
                return $matches[0];
            }

            $entity = $this->entity($data['id']);

            // No entity found, the user might not be allowed to see it
            if (empty($entity) || $entity->isMissingChild()) {
                $name = __('crud.history.unknown');
                $dataName = $name;
            } else {
                $name = $entity->name;
                $dataName = Str::replace('"', '&quot;', $entity->name);
            }

            return '<a href="#" class="mention" data-name="' . $dataName . '" data-mention="' . $matches[0]
                . '">' . $name . '</a>';
        }, $this->text);

        return $this;
    }

    /**
     * Replace mentions of attributes to a visual representation for the text editor
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

            /** @var ?Attribute $attribute */
            $attribute = $this->attribute($id);

            // No entity found, the user might not be allowed to see it
            if (empty($attribute)) {
                $name = __('crud.history.unknown');
            } else {
                $name = $attribute->name;
            }
            if (str_contains($matches[1], '|')) {
                return $matches[0];
            }

            return '<a href="#" class="attribute attribute-mention" data-attribute="' . $matches[0]
                . '">{' . $name . '}</a>';
        }, $this->text);

        return $this;
    }

    protected function parsePostForEdit(string $mention, array $data): string
    {
        $post = $this->post($data['id']);

        $hasCustom = Arr::has($data, 'custom');
        if ($hasCustom || auth()->user()->alwaysAdvancedMentions()) {
            if (! $post) {
                return $mention;
            }
            $advancedName = $this->advancedMentionHelper($post->name);

            return Str::replaceLast(']', $advancedName . ']', $mention);
        }

        // No entity found, the user might not be allowed to see it
        if (empty($post) || $post->entity->isMissingChild()) {
            $name = __('crud.history.unknown');
            $dataName = $name;
        } else {
            $name = $post->name;
            $dataName = Str::replace('"', '&quot;', $post->name);
        }

        return '<a href="#" class="post-mention" data-name="' . $dataName . '" data-mention="' . $mention
            . '">' . $name . '</a>';
    }

    protected function entity(int $id): ?Entity
    {
        if (! Arr::has($this->entities, (string) $id) && ! Arr::has($this->privateEntities, (string) $id)) {
            if ($this->isCopying) {
                CampaignLocalization::forceCampaign($this->campaign);
            }
            $this->entities[$id] = Entity::where(['id' => $id])->first();
        }

        return Arr::get($this->entities, $id);
    }

    protected function post(int $id): ?Post
    {
        if (! Arr::has($this->posts, (string) $id)) {
            $this->posts[$id] = Post::with(['entity', 'entity.tags', 'entity.entityType'])
                ->has('entity')
                ->find($id);
        }

        return Arr::get($this->posts, $id);
    }

    protected function hiddenEntity(int $id): ?Entity
    {
        if (! $this->campaign->showPrivateEntityMentions()) {
            return null;
        }

        if (! Arr::has($this->entities, (string) $id) && ! Arr::has($this->privateEntities, (string) $id)) {
            // @phpstan-ignore-next-line
            $this->privateEntities[$id] = Entity::where(['id' => $id])->withInvisible()->first();
        }

        return Arr::get($this->privateEntities, $id);
    }

    public function preloadEntity(Entity $entity): void
    {
        if (Arr::has($this->entities, (string) $entity->id)) {
            return;
        }
        $this->entities[$entity->id] = $entity;
    }

    protected function alias(int $id): ?EntityAsset
    {
        if (! Arr::has($this->aliases, (string) $id)) {
            $this->aliases[$id] = EntityAsset::alias()->where(['id' => $id])->first();
        }

        return Arr::get($this->aliases, $id);
    }

    protected function attribute(int $id): ?Attribute
    {
        if (! Arr::has($this->attributes, (string) $id)) {
            $this->attributes[$id] = Attribute::where(['id' => $id])->first();
        }

        return Arr::get($this->attributes, $id, null);
    }

    /**
     * Pre-fetch all mentioned entities
     */
    protected function prepareEntities(): void
    {
        // First, let's prepare all mentions to do a single query on the entities table
        $this->mentionedEntities = [];
        preg_replace_callback('`\[([a-z_-]+):(.*?)\]`i', function ($matches) {
            $segments = explode('|', $matches[2]);
            $id = (int) $segments[0];

            if (! in_array($id, $this->mentionedEntities)) {
                $this->mentionedEntities[] = $id;
            }

            return $matches[0];
        }, $this->text);

        // Remove those already cached in memory
        $ids = [];
        // @phpstan-ignore-next-line
        foreach ($this->mentionedEntities as $id) {
            if (! Arr::has($this->entities, $id)) {
                $ids[] = $id;
            }
        }

        // @phpstan-ignore-next-line
        if (empty($ids)) {
            return;
        }

        // Directly get with the mentioned entity types (provided they are valid)
        // @phpstan-ignore-next-line
        $entities = Entity::whereIn('id', $ids)->with(['tags:id,name,slug', 'entityType:id,code,is_special'])->get();
        // dump(count($ids));
        foreach ($entities as $entity) {
            $this->entities[$entity->id] = $entity;
            $findKey = array_search($entity->id, $ids);
            unset($ids[$findKey]);
        }
        $this->hiddenEntities = $ids;
    }

    /**
     * Pre-fetch all private mentioned entities
     */
    protected function prepareHiddenEntities(): void
    {
        // For some reason this is sometimes false
        if (! isset($this->campaign)) {
            $this->campaign = CampaignLocalization::getCampaign();
        }
        if (! $this->campaign->showPrivateEntityMentions()) {
            return;
        }

        // Remove those already cached in memory
        $ids = [];
        foreach ($this->hiddenEntities as $id) {
            if (! Arr::has($this->privateEntities, $id)) {
                $ids[] = $id;
            }
        }

        if (empty($ids)) {
            return;
        }

        // Directly get with the mentioned entity types (provided they are valid)
        // @phpstan-ignore-next-line
        $entities = Entity::whereIn('id', $ids)->with(['entityType:id,code,is_special'])->withInvisible()->get();
        // dump(count($ids));
        foreach ($entities as $entity) {
            $this->privateEntities[$entity->id] = $entity;
        }
    }

    /**
     * Pre-fetch the attributes of the entity
     */
    protected function prepareAttributes()
    {
        // Remove those already cached in memory
        $ids = [];
        foreach ($this->mentionedAttributes as $id) {
            if (! Arr::has($this->attributes, $id)) {
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
     */
    protected function validEntityType(string $type): bool
    {
        return in_array($type, $this->validEntityTypes());
    }

    /**
     * List of valid entity types
     */
    protected function validEntityTypes(): array
    {
        if (! empty($this->validEntityTypes)) {
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
            if (! in_array($id, $this->mentionedAttributes)) {
                $this->mentionedAttributes[] = $id;
            }

            return $matches[0];
        }, $this->text);

        // Pre-fetch all the entities
        $this->prepareAttributes();

        // Extract links from the entry to foreign
        $this->text = preg_replace_callback('`\{attribute:(.*?)\}`i', function ($matches) {
            $id = (int) $matches[1];
            $attribute = $this->attribute($id);
            $fallback = '';
            if (str_contains($matches[1], '|')) {
                $fallback = Str::after($matches[1], '|');
            }
            // No entity found, the user might not be allowed to see it, if theres a fallback, apply it
            if (empty($attribute)) {
                if (! $fallback) {
                    $replace = '<i class="unknown-mention unknown-attribute">' . __('crud.history.unknown') . '</i>';
                } else {
                    $replace = '<i class="unknown-mention unknown-attribute">' . $fallback . '</i>';
                }
            } else {
                $replace = '<span class="attribute attribute-mention" data-title="' . e($attribute->name)
                    . '" data-toggle="tooltip">' . $attribute->mappedValue() . '</span>';
            }

            return $replace;
        }, $this->text);
    }

    /**
     * Replace any table-of-content blocks with a real HTML table of content, adding unique ids to each heading
     * so that links can work.
     *
     * @return void
     */
    protected function mapCodes()
    {
        // Re-use the same markupFixer to keep references of previously generated slugs on this page
        if (! isset($this->markupFixer)) {
            $this->markupFixer = new MarkupFixer(null, new TocSlugify);
        }
        // $markupFixer = new MarkupFixer(null, new TocSlugify());
        $tocGenerator = new \TOC\TocGenerator;
        $this->text = $this->markupFixer->fix($this->text);

        if (! Str::contains($this->text, '{table-of-contents}')) {
            return;
        }

        // $this->text = $this->markupFixer->fix($this->text);
        $toc = $tocGenerator->getHtmlMenu($this->text);
        $this->text = Str::replaceFirst(
            '{table-of-contents}',
            '<div class="toc">' . $toc . "</div>\n",
            $this->text
        );
    }

    /**
     * Protect from rendering future field:entry mentions to avoid endless loops
     */
    protected function lockEntryRendering(): void
    {
        $this->enableEntryField = false;
    }

    /**
     * Re-enable rendering field:entry mentions
     */
    protected function unlockEntryRendering(): void
    {
        $this->enableEntryField = true;
    }

    protected function mentionPost(array $data): string
    {
        $post = $this->post($data['id']);
        $isTranscluding = Arr::get($data, 'text') === 'transclude';
        if (! $post) {
            if ($this->onlyName || $isTranscluding) {
                return __('crud.history.unknown');
            }

            return Arr::get(
                $data,
                'text',
                '<i class="unknown-mention unknown-entity">' . __('crud.history.unknown') . '</i>'
            );
        }

        $url = route('entities.show', [$this->campaign, $post->entity, '#post-' . $post->id]);
        $tooltipUrl = route('entities.tooltip', [$this->campaign, $post->entity]);

        $cssClasses = ['entity-mention'];

        $tagClasses = [];
        foreach ($post->entity->tags as $tag) {
            $tagClasses[] = 'id-' . $tag->id;
            $tagClasses[] = $tag->slug;
        }

        if ($isTranscluding) {
            if ($this->enableEntryField) {
                $this->lockEntryRendering();
                $parsedTargetEntry = $post->parsedEntry();
                $this->unlockEntryRendering();
            } else {
                $parsedTargetEntry = $post->entry;
            }
            $cssClasses[] = 'mention-field-post block';
            $entityName = '<a href="' . $url . '"'
                . ' class="entity-mention-name block mb-2"'
                . ' data-toggle="tooltip-ajax"'
                . ' data-id="' . $post->entity->id . '"'
                . ' data-url="' . $tooltipUrl . '"'
                . '>'
                . $post->name
                . '</a>';

            return '<span class="' . implode(' ', $cssClasses) . '"'
                . ' data-entity-tags="' . implode(' ', $tagClasses) . '"'
                . '>'
                . $entityName
                . '<div class="mention-post-content">'
                . $parsedTargetEntry
                . '</div>'
                . '</span>';
        }

        if ($this->onlyName) {
            return Arr::get($data, 'text', $post->name);
        }

        return '<a href="' . $url . '"'
            . ' class="' . implode(' ', $cssClasses) . '"'
            . ' data-entity-tags="' . implode(' ', $tagClasses) . '"'
            . ' data-entity-type="' . $post->entity->entityType->code . '"'
            . ' data-toggle="tooltip-ajax"'
            . ' data-id="' . $post->entity->id . '"'
            . ' data-url="' . $tooltipUrl . '"'
//                    . ' data-mention-url="' . route('entities.tooltip', $entity). '"'
//                    . ' title="<i class=\'fa fa-spinner fa-spin\'></i>"'
            . '>'
            . Arr::get($data, 'text', $post->name)
            . '</a>';
    }
}
