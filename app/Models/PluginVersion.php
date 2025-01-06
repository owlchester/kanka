<?php

namespace App\Models;

use App\Facades\Avatar;
use App\Facades\CampaignLocalization;
use App\Facades\Mentions;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

/**
 * Class PluginVersion
 * @package App\Models
 *
 * @property int $plugin_id
 * @property string $uuid
 * @property string $version
 * @property string $entry
 * @property string $content
 * @property string $fonts
 * @property string $css
 * @property Carbon $updated_at
 * @property int $status_id
 * @property int $approved_by
 * @property Plugin $plugin
 * @property string|array $json
 */
class PluginVersion extends Model
{
    /**  */
    protected Entity $entity;

    /** @var Collection|Attribute[] */
    protected $entityAttributes;

    /** @var array A list of all the attributes being referenced in the character sheet */
    protected array $templateAttributes = [];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'json' => 'array'
    ];

    /**
     * Get the attributes (stored in the json)
     */
    public function getAttributesAttribute(): array
    {
        return Arr::get($this->json, 'attributes', []);
    }

    /**
     * Get the css (stored in the json)
     */
    public function getCssAttribute(): string
    {
        return Arr::get($this->json, 'css', '');
    }

    /**
     * Get the translations (stored in the json)
     */
    public function getTranslationsAttribute(): array
    {
        return Arr::get($this->json, 'translations', []);
    }

    /**
     * @return string|string[]|null
     */
    public function content(Entity $entity)
    {
        // Let people update their plugins before using the new syntax
        if ($this->updated_at->gt('2021-03-30 17:00:00')) {
            return $this->renderBlade($entity);
        }

        $this->entityAttributes = $entity->allAttributes;
        $html = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
            $name = (string) $matches[1];
            return $this->attribute($name);
        }, $this->content);


        // Replace < and > in logical blocks
        //$html = str_replace(['&lt;', '&gt;'], ['<', '>'], $html);

        //dump($html);
        //return $html;

        // If-Else condition

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@endif`si', function ($matches) {
            return $this->ifBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@else(.*?)@endif`si', function ($matches) {
            return $this->ifElseBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@empty\((.*?)\)(.*?)@endempty`si', function ($matches) {
            return (string) $this->emptyBlock($matches);
        }, $html);
        $html = preg_replace_callback('`@notempty\((.*?)\)(.*?)@endnotempty`si', function ($matches) {
            return (string) !$this->emptyBlock($matches);
        }, $html);

        return $html;
    }

    /**
     */
    public function css(): string
    {
        $css = (string) $this->css;
        return $css;
    }

    /**
     * The new rendering engine using Blade
     * @return false|string
     */
    protected function renderBlade(Entity $entity)
    {
        $html = $this->content;
        $html = str_replace(['&lt;', '&gt;', '&amp;&amp;'], ['<', '>', '&&'], $html);

        // Get all the referenced attributes in the character sheet so that they are set to null if an entity
        // doesn't have the attribute
        $html = preg_replace_callback('`\{\{(.*?[^(\!])\}\}`i', function ($matches) {
            $attribute = mb_trim((string) $matches[1]);
            // If it's a comment, we can safely ignore it
            if (Str::startsWith($attribute, '--') && Str::endsWith($attribute, '--')) {
                return '{{' . $attribute . '}}';
            }
            // Flag this as an attribute that is referenced
            $name = Str::after($attribute, '$');
            $this->templateAttributes[$name] = null;
            return '{{ ' . $attribute . ' }}';
        }, $html);

        $html = preg_replace_callback('`\{\!\!(.*?[^(\!])\!\!\}`i', function ($matches) {
            $attribute = mb_trim((string) $matches[1]);
            $name = Str::after($attribute, '$');
            // Flag this as an attribute that is referenced
            $this->templateAttributes[$name] = null;
            return '{!! ' . $attribute . ' !!}';
        }, $html);


        // Blacklisted commands
        $html = str_replace([
            '@php', '@dd', '@inject', '@yield', '@section', '@session', '@env', '@once', '@push', '@csrf',
            '@use',
            '@include', '\Illuminate\\'
        ], [
            '', '', '', '', '', '', '', '', '', '', '', '', ''
        ], $html);

        // Remove more blacklisted stuff than can go unnoticed
        $html = preg_replace('`dd\((.*?)\)`i', '', $html);
        $html = preg_replace('`config\((.*?)\)`i', '', $html);

        // First loop to replace i18n with ()) in the texts
        $regexp = '`\@i18n(\((?:[^)(]++|(?1))*\))`i';
        $html = preg_replace_callback($regexp, function ($matches) {
            return '{{ trans' . $matches[1] . ' }}';
        }, $html);

        // Next loop on the easy non complicated i18n calls without ()
        $regexp = '`\@i18n\((.*?)\)`i';
        $html = preg_replace_callback($regexp, function ($matches) {
            return '{{ trans' . $matches[1] . ' }}';
        }, $html);

        $this->loadTranslations();

        $html = Blade::compileString($html);

        list($data, $ids, $checkboxes) = $this->prepareBladeData($entity);

        $html = preg_replace_callback('`\@liveAttribute\(\'(.*?[^)])\'\)`i', function ($matches) use ($data, $ids, $checkboxes) {
            $attr = mb_trim((string) $matches[1]);
            if (!isset($data[$attr])) {
                return $matches[0];
            }
            $value = $data[$attr];
            if (in_array($attr, $checkboxes)) {
                if ($data[$attr] === 'on' || $data[$attr] === '1') {
                    $value = '<i class="fa-solid fa-check" aria-hidden="true" aria-label="checked"></i>';
                } else {
                    $value = '<i class="fa-solid fa-times" aria-hidden="true" aria-label="unchecked"></i>';
                }
            }
            return '<span class="live-edit" data-id="' . $ids[$attr] . '">' . $value . '</span>';
        }, $html);

        $obLevel = ob_get_level();
        ob_start() && extract($data, EXTR_SKIP);

        $errors = null;

        try {
            eval('?' . '>' . $html);
            $blade = ob_get_clean();
            return $blade;
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $errors = $e->getMessage();
            //throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $errors = $e->getMessage();

            //throw new FatalThrowableError($e);
        }
        return '<div class="alert alert-danger">
            ' . __('attributes/templates.errors.marketplace.rendering') . (!empty($errors) ?
                '<br /><br />' . __('attributes/templates.errors.marketplace.hint') . ': ' . $errors . ' (line ' . $e->getLine() . ')' : null) . '
        </div>' . $this->debug($data);
    }

    /**
     * Build a html list of all variables
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function debug(mixed $data): string
    {
        $html = '<div class="m-2 p-2 text-xs">
            <h4 class="mb-5">Debug info - the following variables are available</h4>
            ';

        foreach ($data as $key => $val) {
            if (!is_array($val) && !is_object($val)) {
                $html .= '<dtk>$' . $key . '</dtk> <code>' . (empty($val) ? null : e($val)) . '</code><br />';
            } elseif (is_array($val)) {
                $html .= '<dtk class="">$' . $key . '</dtk>';
                if (empty($val)) {
                    $html .= '<code>NULL</code><br />';
                } else {
                    $html .= '<ul class="m-0">';
                    foreach ($val as $k => $v) {
                        if (is_array($v)) {
                            $html .= '<li><dtk>' . $k . '</dtk></li>';
                            continue;
                        }
                        $html .= '<li><dtk>' . $k . '</dtk> <code>' . $v . '</code></li>';
                    }
                    $html .= '</ul>';
                }
            }
        }
        return $html . '</div>';
    }

    /**
     */
    protected function attribute(string $name): string
    {
        /** @var Attribute|null $attr */
        $attr = $this->entityAttributes->where('name', $name)->first();
        if (!empty($attr)) {
            if ($attr->isText()) {
                return nl2br($attr->mappedValue());
            }
            return $attr->mappedValue();
        }

        return '<i class="missing-attribute">' . $name . '</i>';
    }

    /**
     * If Else block
     */
    protected function ifElseBlock(array $matches)
    {
        // Test on a missing attribute always returns false
        $trimmed = mb_trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return $matches[3];
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(mb_trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }
            return null;
        }
        if (!empty($condition)) {
            return $matches[2];
        } else {
            return $matches[3];
        }
    }

    /**
     * If block
     * @return mixed|null
     */
    protected function ifBlock(array $matches)
    {
        // If there is an else in the block, let the if-else block handle it later
        if (Str::contains($matches[2], '@else')) {
            return $matches[0];
        }
        // Test on a missing attribute always returns false
        $trimmed = mb_trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return null;
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(mb_trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<', '&lt;', '&gt;'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }
            return null;
        }
        if (!empty($condition)) {
            return $matches[2];
        }
        return null;
    }

    /**
     * Evaluate a condition
     */
    protected function evaluateCondition(string $condition): bool
    {
        // >=
        if (Str::contains($condition, '&gt;=')) {
            $segments = explode('&gt;=', $condition);
            return (int) mb_trim($segments[0]) >= (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '&lt;=')) {
            $segments = explode('&lt;=', $condition);
            return (int) mb_trim($segments[0]) <= (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '&gt;')) {
            $segments = explode('&gt;', $condition);
            return (int) mb_trim($segments[0]) > (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '&lt;')) {
            $segments = explode('&lt;', $condition);
            return (int) mb_trim($segments[0]) < (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '=')) {
            $segments = explode('=', $condition);
            return mb_trim($segments[0]) == mb_trim($segments[1]);
        }
        return false;
    }

    protected function emptyBlock(array $matches)
    {
        $condition = mb_trim($matches[1]);
        if (Str::contains($condition, '<i class="missing">')) {
            return false;
        }
        return !(empty($condition));
    }

    /**
     * Add the plugin's translations to memory
     */
    protected function loadTranslations(): void
    {
        // Always add the user's locale + en as a fallback
        $userLocale = app()->getLocale();
        $locales = [$userLocale, 'en'];

        foreach ($this->getTranslationsAttribute() as $translation) {
            if (!in_array($translation['locale'], $locales)) {
                continue;
            }
            $lines['*.' . $translation['base']] = $translation['translation'];

            app('translator')->addLines($lines, $userLocale);
        }
    }

    /**
     * Prepare all the attributes of the entity to be accessible in blade
     */
    protected function prepareBladeData(Entity $entity): array
    {
        $data = [];
        $ids = [];
        $checkboxes = [];
        $this->entityAttributes = $entity->allAttributes;
        $allAttributes = [];
        foreach ($this->entityAttributes as $attr) {
            $name = $attr->exposedName(false);
            $data[$name] = $attr->mappedValue();
            $ids[$name] = $attr->id;
            if ($attr->isText()) {
                $data[$name] = nl2br($data[$name]);
            } elseif ($attr->isCheckbox()) {
                $checkboxes[] = $name;
            }
            //dump('mapping ' . $name . ' to ' . $attr->mappedValue());

            // Cleanup the name for ranged values
            $allAttributes[$name] = $data[$name];
            unset($this->templateAttributes[$name]);
        }

        // We need this for some blade directives like foreach
        $data['__env'] = app(\Illuminate\View\Factory::class);
        $data['attributes'] = $allAttributes;
        $data['_abilities'] = $this->abilities($entity);

        // Share some attributes to plugin developers
        $data['_locale'] = app()->getLocale();
        $data['_entity_name'] = $entity->name;
        $data['_entity_type'] = $entity->child->type;
        $data['_entity_type_name'] = $entity->type();

        if ($entity->isCharacter()) {
            /** @var Character $character */
            $character = $entity->child;
            $data['_character_title'] = $character->title;
            $data['_character_gender'] = $character->sex;
            $data['_character_age'] = $character->age;
            $data['_character_pronouns'] = $character->pronouns;

            $appearances = $character->appearances;
            $data['_character_appearances'] = $appearances->pluck('entry', 'name')->toArray();
            $traits = $character->personality;
            $data['_character_traits'] = $traits->pluck('entry', 'name')->toArray();
        }

        $tags = [];
        foreach ($entity->tags as $tag) {
            $tags[$tag->slug] = $tag->name;
        }
        $data['_tags'] = $tags;

        $campaign = CampaignLocalization::getCampaign();
        $data['_superboosted'] = $campaign->superboosted();
        $data['_premium'] = $campaign->premium();

        // Add any missing attributes to be accessible in blade
        foreach ($this->templateAttributes as $name => $val) {
            if (isset($data[$name])) {
                continue;
            }
            $data[$name] = $val;
        }

        if (!isset($data['openLI'])) {
            $data['openLI'] = '<li>';
        }
        if (!isset($data['closeLI'])) {
            $data['closeLI'] = '</li>';
        }
        if (!isset($data['openOL'])) {
            $data['openOL'] = '<ol>';
        }
        if (!isset($data['closeOL'])) {
            $data['closeOL'] = '</ol>';
        }
        if (!isset($data['openUL'])) {
            $data['openUL'] = '<ul>';
        }
        if (!isset($data['closeUL'])) {
            $data['closeUL'] = '</ul>';
        }

        return [$data, $ids, $checkboxes];
    }

    /**
     * Load abilities of the entity and make them available to blade
     * @throws Exception
     */
    protected function abilities(Entity $entity): array
    {
        $abilities = $entity
            ->abilities()
            ->has('ability')
            ->has('ability.entity')
            ->with(['ability', 'ability.parent', 'ability.entity', 'ability.entity.image', 'ability.entity.tags'])
            ->get();
        $data = [];
        /** @var EntityAbility $abi */
        foreach ($abilities as $abi) {
            $tags = [];
            foreach ($abi->ability->entity->tags as $tag) {
                $tags[] = $tag->slug;
            }

            $parent = null;
            if (!empty($abi->ability->parent)) {
                $parent = [
                    'name' => $abi->ability->parent->name,
                    'slug' => Str::slug($abi->ability->parent->name),
                ];
            }

            $ability = [
                'id' => $abi->id,
                'ability_id' => $abi->ability_id,
                'name' => $abi->ability->name,
                'slug' => Str::slug($abi->ability->name),
                'type' => $abi->ability->type,
                'entry' => $abi->ability->parsedEntry(),
                'charges' => $abi->ability->charges,
                'note' => Mentions::mapAny($abi, 'note'),
                'note_raw' => $abi->note,
                'used_charges' => $abi->charges,
                'thumb' => '<img src="' . Avatar::entity($abi->ability->entity)->child($abi->ability)->size(40)->thumbnail() . '" class="ability-thumb"></i>',
                'link' => '<a href="' . $abi->ability->getLink() . '" class="ability-link">' . $abi->ability->name . '</a>',
                'tags' => $tags,
                'parent' => $parent,
            ];
            $data[] = $ability;
        }

        return $data;
    }

    /**
     * @return Builder
     */
    public function scopePublishedVersions(Builder $query, int $pluginCreator)
    {
        if ($pluginCreator === auth()->user()->id) {
            return $query->whereIn('status_id', [1, 3]);
        }
        return $query->where('status_id', 3);
    }

    public function entities(): HasMany
    {
        return $this->hasMany(PluginVersionEntity::class);
    }

    /**
     * Determine if the current version is a draft
     */
    public function isDraft(): bool
    {
        return $this->status_id === 1;
    }
}
