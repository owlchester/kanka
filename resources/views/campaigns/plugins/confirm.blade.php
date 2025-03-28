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
        <p>{{ __('campaigns/plugins.import.helper', [
            'count' => $version->version->entities()->count(),
            'plugin' => $plugin->name
        ]) }}</p>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="force_private" />
                {{ __('campaigns/plugins.import.option_private') }}
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="only_new" />
                {{ __('campaigns/plugins.import.option_only_import') }}
            </label>
        </div>

        <x-dialog.footer>
            <input type="submit" value="{{ __('campaigns/plugins.import.button') }}" class="btn2 btn-primary" />
        </x-dialog.footer>
    </x-form>
</article>

