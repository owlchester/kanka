<x-dialog.header>
    {!! __('campaigns/styles.theme.title') !!}
</x-dialog.header>
<article>
    {!! Form::model($campaign, ['route' => ['campaign-theme.save', $campaign], 'method' => 'POST', 'class' => 'w-full max-w-lg text-left']) !!}
    <x-forms.field field="theme" :label="__('campaigns.fields.theme')" :tooltip="true" :helper="__('campaigns.helpers.theme')">
        {!! Form::select(
            'theme_id',
            $themes,
            null,
            ['class' => 'w-full']
        ) !!}
        <p class="text-neutral-content md:hidden">{{ __('campaigns.helpers.theme') }}</p>
    </x-forms.field>

    <x-dialog.footer>
        <button class="btn2 btn-primary">{{ __('crud.actions.apply') }}</button>
    </x-dialog.footer>
{!! Form::close() !!}
</article>
