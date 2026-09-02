<?php

use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\PluginVersion;
use App\Renderers\CharacterSheets\Twig;

test('renders entity data under the entry variable', function () {
    $version = new PluginVersion;
    $version->content = '<h1>{{ entry.name }}</h1>{% for item in entry.items %}<p>{{ item }}</p>{% endfor %}';
    $plugin = new CampaignPlugin;
    $plugin->setRelation('version', $version);
    $campaign = new Campaign;
    $campaign->name = 'Campaign';

    $renderer = new class extends Twig
    {
        protected function properties(): array
        {
            return [[], [], []];
        }

        protected function prepareEntityData(): array
        {
            return [
                'name' => 'Hero',
                'items' => ['One', 'Two'],
            ];
        }

        protected function abilities(): array
        {
            return [];
        }

        protected function loadTranslations(): void {}
    };

    $html = $renderer->campaign($campaign)->plugin($plugin)->render();

    expect($html)
        ->toContain('<h1>Hero</h1>')
        ->toContain('<p>One</p>')
        ->toContain('<p>Two</p>');
});

test('escapes entity data by default', function () {
    $version = new PluginVersion;
    $version->content = '{{ entry.name }}';
    $plugin = new CampaignPlugin;
    $plugin->setRelation('version', $version);
    $campaign = new Campaign;
    $campaign->name = 'Campaign';

    $renderer = new class extends Twig
    {
        protected function properties(): array
        {
            return [[], [], []];
        }

        protected function prepareEntityData(): array
        {
            return ['name' => '<script>alert(1)</script>'];
        }

        protected function abilities(): array
        {
            return [];
        }

        protected function loadTranslations(): void {}
    };

    $html = $renderer->campaign($campaign)->plugin($plugin)->render();

    expect($html)->toBe('&lt;script&gt;alert(1)&lt;/script&gt;');
});

test('renders raw entity data when requested', function () {
    $version = new PluginVersion;
    $version->content = '{{ entry.description|raw }}';
    $plugin = new CampaignPlugin;
    $plugin->setRelation('version', $version);
    $campaign = new Campaign;
    $campaign->name = 'Campaign';

    $renderer = new class extends Twig
    {
        protected function properties(): array
        {
            return [[], [], []];
        }

        protected function prepareEntityData(): array
        {
            return ['description' => '<strong>Hero</strong>'];
        }

        protected function abilities(): array
        {
            return [];
        }

        protected function loadTranslations(): void {}
    };

    $html = $renderer->campaign($campaign)->plugin($plugin)->render();

    expect($html)->toBe('<strong>Hero</strong>');
});

test('renders live attributes', function () {
    $version = new PluginVersion;
    $version->content = "{{ live('race') }}";
    $plugin = new CampaignPlugin;
    $plugin->setRelation('version', $version);
    $campaign = new Campaign;
    $campaign->name = 'Campaign';

    $renderer = new class extends Twig
    {
        protected function properties(): array
        {
            return [['race' => 'Elf'], ['race' => 42], []];
        }

        protected function prepareEntityData(): array
        {
            return ['name' => 'Hero'];
        }

        protected function abilities(): array
        {
            return [];
        }

        protected function loadTranslations(): void {}
    };

    $html = $renderer->campaign($campaign)->plugin($plugin)->render();

    expect($html)->toBe('<span class="live-edit" data-id="42">Elf</span>');
});

test('renders live checkbox attributes', function () {
    $version = new PluginVersion;
    $version->content = "{{ live('inspiration') }}";
    $plugin = new CampaignPlugin;
    $plugin->setRelation('version', $version);
    $campaign = new Campaign;
    $campaign->name = 'Campaign';

    $renderer = new class extends Twig
    {
        protected function properties(): array
        {
            return [['inspiration' => 'on'], ['inspiration' => 43], ['inspiration']];
        }

        protected function prepareEntityData(): array
        {
            return ['name' => 'Hero'];
        }

        protected function abilities(): array
        {
            return [];
        }

        protected function loadTranslations(): void {}
    };

    $html = $renderer->campaign($campaign)->plugin($plugin)->render();

    expect($html)->toBe('<span class="live-edit" data-id="43"><i class="fa-solid fa-check" aria-hidden="true" aria-label="checked"></i></span>');
});
