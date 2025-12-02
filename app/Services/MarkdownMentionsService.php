<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\Post;
use App\Traits\CampaignAware;
use App\Traits\MentionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MarkdownMentionsService
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

    /**
     * Parse a model's text for markdown export
     */
    public function parseForMarkdown(Model $model, string $field = 'entry'): string
    {
        return $this->prepareEntity($model, $field);
    }

    protected function prepareEntity(Model $model, string $field): string
    {
        // We have to cast to a string for when the entity was created in the API with a NULL entry
        $this->text = (string) $model->$field;

        return $this->replaceForMarkdown();
    }


    protected function replaceForMarkdown(): string
    {
        // Extract links from the entry to foreign
        $this
            ->parseMentions()
            ->parseAttributes();

        return (string) $this->text;
    }

    /**
     * Replace mentions of entities to a supported markdown converter link
     */
    protected function parseMentions(): self
    {
        $this->text = preg_replace_callback('`\[([a-z_-]+):(.*?)\]`i', function ($matches) {
            $data = $this->extractData($matches);

            if ($data['type'] === 'post') {
                return $this->parsePost($data);
            }
            $hasCustom = Arr::has($data, 'custom');

            // If the user always wants advanced mentions, we force the [] syntax upon them
            if ($hasCustom || auth()->user()->alwaysAdvancedMentions()) {

                //Get entity
                $entity = $this->entity($data['id']);
                if (!empty($entity) && $entity->entityType->isCustom()) {
                    $moduleName = Str::slug($entity->entityType->plural() . '_' . $entity->entityType->id);
                } elseif (!empty($entity)) {
                    $moduleName = Str::slug($entity->entityType->plural());  
                }

                //If no entity then render as unknown
                if (empty($entity) || ($entity->hasChild() && $entity->isMissingChild())) {
                    return __('crud.history.unknown');
                }

                //If field, render that.
                if (Arr::has($data, 'field')) {
                    $name = $entity->name;
                    $field = $data['field'];
                    //Check for field
                    if(isset($entity->$field)) {
                        $name = $entity->$field;
                    }

                    return '<a href="'
                        . str_replace(' ', '-', $moduleName) . '/'
                        . str_replace(' ', '-', Str::slug($entity->name)) . '_' . $entity->id
                        . '">'
                        . $name
                        . '</a>';
                }
                
                //If no alias, render name
                if (! Arr::has($data, 'alias')) {

                    $name = $entity->name;

                    //Check for custom name
                    if(isset($data['text'])) {
                        $name = $data['text'];
                    }

                    return '<a href="'
                        . str_replace(' ', '-', $moduleName) . '/'
                        . str_replace(' ', '-', Str::slug($entity->name)) . '_' . $entity->id
                        . '">'
                        . $name
                        . '</a>';
                }


                // An alias was attached, try loading that too
                $alias = $this->alias($data['alias']);
                if (empty($alias) || empty($alias->entity)) {

                    return '<a href="' 
                        . str_replace(' ', '-', $moduleName) . '/' 
                        . str_replace(' ', '-', Str::slug($entity->name)) . '_' . $entity->id 
                        . '">' . $entity->name . '</a>';
                }
                
                //If alias use that.
                return '<a href="'
                    . str_replace(' ', '-', $moduleName) . '/'
                    . str_replace(' ', '-', Str::slug($entity->name)) . '_' . $entity->id
                    . '">'
                    . $alias->name
                    . '</a>';
            }

            $entity = $this->entity($data['id']);

            // No entity found, the user might not be allowed to see it
            if (empty($entity) || ($entity->hasChild() && $entity->isMissingChild())) {
                return __('crud.history.unknown');
            } else {
                //Get module name
                if (!empty($entity) && $entity->entityType->isCustom()) {
                    $moduleName = Str::slug($entity->entityType->plural() . '_' . $entity->entityType->id);
                } elseif (!empty($entity)) {
                    $moduleName = Str::slug($entity->entityType->plural());  
                }
                //Render normally
                return '<a href="'
                    . str_replace(' ', '-', $moduleName) . '/'
                    . str_replace(' ', '-', Str::slug($entity->name)) . '_' . $entity->id
                    . '">'
                    . $entity->name
                    . '</a>';
            }

        }, $this->text);

        return $this;
    }

    /**
     * Replace mentions of attributes to supported markdown converter link
     */
    protected function parseAttributes(): self
    {
        // Extract links from the entry to attribute
        $this->text = preg_replace_callback('`\{attribute:(.*?)\}`i', function ($matches) {
            $id = (int) $matches[1];

            /** @var ?Attribute $attribute */
            $attribute = $this->attribute($id);

            // No entity found, the user might not be allowed to see it
            if (empty($attribute)) {
                return __('crud.history.unknown');
            }
            //Get entity type for linking
            if ($attribute->entity->entityType->isCustom()) {
                $moduleName = Str::slug($attribute->entity->entityType->plural() . '_' . $attribute->entity->entityType->id);
            } else {
                $moduleName = Str::slug($attribute->entity->entityType->plural());  
            }
            //Render attribute.
            return '<a href="'
                . str_replace(' ', '-', $moduleName) . '/'
                . str_replace(' ', '-', Str::slug($attribute->entity->name)) . '_' . $attribute->entity->id
                . '">'
                . $attribute->value
                . '</a>';

        }, $this->text);

        return $this;
    }

    protected function parsePost(array $data): string
    {
        $post = $this->post($data['id']);

        //If no post then render unknown
        if (empty($post) || $post->entity->isMissingChild()) {
            return __('crud.history.unknown');
        }

        //Get entitytype from the post
        if ($post->entity->entityType->isCustom()) {
            $moduleName = Str::slug($post?->entity->entityType->plural() . '_' . $post?->entity->entityType->id);
        } else {
            $moduleName = Str::slug($post?->entity->entityType->plural());  
        }

        //If transcluding a post, render its entry
        if (Arr::has($data, 'text') && $data['text'] == 'transclude') {
            return '<a href="'
                . str_replace(' ', '-', $moduleName) . '/'
                . str_replace(' ', '-', Str::slug($post->entity->name)) . '_' . $post->entity->id
                . '">'
                . $post->entry
                . '</a>';
        }

        //Render normally
        return '<a href="'
            . str_replace(' ', '-', $moduleName) . '/'
            . str_replace(' ', '-', Str::slug($post->entity->name)) . '_' . $post->entity->id
            . '">'
            . $post->name
            . '</a>';
    }

    protected function entity(int $id): ?Entity
    {
        if (! Arr::has($this->entities, (string) $id) && ! Arr::has($this->privateEntities, (string) $id)) {
            $this->entities[$id] = Entity::with(['entityType'])->where(['id' => $id])->first();
        }

        return Arr::get($this->entities, $id);
    }

    protected function alias(int $id): ?EntityAsset
    {
        if (! Arr::has($this->aliases, (string) $id)) {
            $this->aliases[$id] = EntityAsset::with(['entity', 'entity.tags', 'entity.entityType'])
                ->alias()
                ->where(['id' => $id])->first();
        }

        return Arr::get($this->aliases, $id);
    }

    protected function attribute(int $id): ?Attribute
    {
        if (! Arr::has($this->attributes, (string) $id)) {
            $this->attributes[$id] = Attribute::with(['entity', 'entity.entityType'])
                ->where(['id' => $id])->first();
        }

        return Arr::get($this->attributes, $id, null);
    }

    protected function post(int $id): ?Post
    {
        if (! Arr::has($this->posts, (string) $id)) {
            $this->posts[$id] = Post::with(['entity', 'entity.entityType'])
                ->has('entity')
                ->find($id);
        }

        return Arr::get($this->posts, $id);
    }

}
