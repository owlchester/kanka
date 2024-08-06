<x-dialog.header>
    {!! __('campaigns/styles.theme.title') !!}
</x-dialog.header>
<article>
    <x-form :action="['campaign-theme.save', $campaign]" class="w-full max-w-lg text-left">
        <x-forms.field field="theme" :label="__('campaigns.fields.theme')" tooltip :helper="__('campaigns.helpers.theme')">

            <x-forms.select name="theme_id" :options="$themes" :selected="$campaign->theme_id ?? null" />
            <p class="text-neutral-content md:hidden">{{ __('campaigns.helpers.theme') }}</p>
        </x-forms.field>

        <x-dialog.footer>
            <button class="btn2 btn-primary">{{ __('crud.actions.apply') }}</button>
        </x-dialog.footer>
    </x-form>
</article>
