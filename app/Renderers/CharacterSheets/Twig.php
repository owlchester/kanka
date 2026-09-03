<?php

namespace App\Renderers\CharacterSheets;

use App\Models\Character;
use Throwable;
use Twig\Environment;
use Twig\Extension\SandboxExtension;
use Twig\Loader\ArrayLoader;
use Twig\Sandbox\SecurityPolicy;
use Twig\TwigFunction;

class Twig extends Renderer
{
    public function render(): string
    {
        [$data, $ids, $checkboxes] = $this->properties();

        $twig = new Environment(new ArrayLoader([
            'character-sheet' => $this->campaignPlugin->version->content,
        ]), [
            'autoescape' => 'html',
            'strict_variables' => false,
        ]);

        $twig->addExtension(new SandboxExtension(
            new SecurityPolicy(
                ['for', 'if', 'set', 'macro', 'apply', 'filter'],
                [
                    'abs', 'capitalize', 'default', 'escape', 'first', 'join', 'keys', 'last', 'length',
                    'lower', 'merge', 'nl2br', 'number_format', 'replace', 'reverse', 'round', 'slice',
                    'raw', 'sort', 'striptags', 'title', 'trim', 'upper', 'url_encode',
                ],
                [],
                [],
                ['live', 'range', 'trans'],
            ),
            true,
        ));

        $twig->addFunction(new TwigFunction('trans', static function (string $key, array $replace = []): string {
            return (string) __($key, $replace);
        }));
        $twig->addFunction(new TwigFunction('live', function (string $attribute) use ($data, $ids, $checkboxes): string {
            if (! isset($data[$attribute], $ids[$attribute])) {
                return '';
            }

            $value = $data[$attribute];
            if (in_array($attribute, $checkboxes, true)) {
                if ($value === 'on' || $value === '1') {
                    $value = '<i class="fa-solid fa-check" aria-hidden="true" aria-label="checked"></i>';
                } else {
                    $value = '<i class="fa-solid fa-times" aria-hidden="true" aria-label="unchecked"></i>';
                }
            }

            return '<span class="live-edit" data-id="' . e($ids[$attribute]) . '">' . $value . '</span>';
        }, ['is_safe' => ['html']]));

        $this->loadTranslations();

        try {
            return $twig->render('character-sheet', $this->variables());
        } catch (Throwable $e) {
            return '<div class="alert alert-danger">'
                . __('attributes/templates.errors.marketplace.rendering')
                . '<br /><br />'
                . __('attributes/templates.errors.marketplace.hint')
                . ': ' . e($e->getMessage())
                . '</div>';
        }
    }

    protected function variables(): array
    {
        return [
            'properties' => $this->properties()[0],
            'entry' => $this->prepareEntityData(),
            'abilities' => $this->abilities(),
            'locale' => app()->getLocale(),
            'campaign' => [
                'name' => $this->campaign->name,
                'premium' => $this->campaign->premium(),
            ],
        ];
    }

    protected function properties(): array
    {
        $data = [];
        $ids = [];
        $checkboxes = [];
        $this->entityAttributes = $this->entity->allAttributes;
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
            // dump('mapping ' . $name . ' to ' . $attr->mappedValue());

            // Clean up the name for ranged values
            $allAttributes[$name] = $data[$name];
            unset($this->templateAttributes[$name]);
        }

        // Add any missing attributes to be accessible in blade
        foreach ($this->templateAttributes as $name => $val) {
            if (isset($data[$name])) {
                continue;
            }
            $data[$name] = $val;
        }

        return [$data, $ids, $checkboxes];
    }

    /**
     * Prepare all the attributes of the entity to be accessible in blade
     */
    protected function prepareEntityData(): array
    {
        // Share some attributes to plugin developers
        $data['name'] = $this->entity->name;
        $data['type'] = $this->entity->type;
        $data['category'] = [
            'id' => $this->entity->entityType->code,
            'code' => $this->entity->entityType->code,
            'singular' => $this->entity->entityType->name(),
            'plural' => $this->entity->entityType->plural(),
        ];

        if ($this->entity->isCharacter()) {
            /** @var Character $character */
            $character = $this->entity->child;
            $data['title'] = $character->title;
            $data['gender'] = $character->sex;
            $data['age'] = $character->age;
            $data['pronouns'] = $character->pronouns;

            $appearances = $character->appearances;
            $data['appearances'] = $appearances->pluck('entry', 'name')->toArray();
            $traits = $character->personality;
            $data['traits'] = $traits->pluck('entry', 'name')->toArray();
        }

        if ($this->entity->status) {
            $data['status'] = $this->entity->status->key;
        }

        $tags = [];
        foreach ($this->entity->tags as $tag) {
            $tags[$tag->slug] = $tag->entity->name;
        }
        $data['tags'] = $tags;

        return $data;
    }
}
