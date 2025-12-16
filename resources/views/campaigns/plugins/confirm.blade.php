<?php /**
 * @var \App\Models\Plugin $plugin
 * @var \App\Models\CampaignPlugin $version
 */
?>
<x-dialog.header>
    {!! __('campaigns/plugins.import.title', ['plugin' => $plugin->name]) !!}
</x-dialog.header>

<article class="text-left max-w-2xl p-4 md:px-6">
    @include('partials.errors')

    <x-form :action="['campaign_plugins.import', $campaign, $plugin]">
        <x-grid type="1/1">
            <x-helper>
                <p>{!! __('campaigns/plugins.import.helper', [
                'count' => $version->version->entities()->count(),
                'plugin' => '<a href="' . $plugin->libraryUrl() . '" class="text-link">' . $plugin->name . '</a>'
            ]) !!}</p>
            </x-helper>

            <x-forms.field field="force_private" :label=" __('campaigns/plugins.import.fields.private')">
                <input type="hidden" name="force_private" value="0" />
                <x-checkbox :text="__('campaigns/plugins.import.option_private')">
                    <input type="checkbox" name="force_private" />
                </x-checkbox>
            </x-forms.field>

            <x-forms.field field="only_new" :label=" __('campaigns/plugins.import.fields.only_new')">
                <input type="hidden" name="only_new" value="0" />
                <x-checkbox :text="__('campaigns/plugins.import.option_only_import')">
                    <input type="checkbox" name="only_new" />
                </x-checkbox>
            </x-forms.field>
        </x-grid>

        <x-dialog.footer>
            <input type="submit" value="{{ __('campaigns/plugins.import.button') }}" class="btn2 btn-primary" />
        </x-dialog.footer>
    </x-form>
</article>

