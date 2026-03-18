<x-dialog.header>
    {{ __('datagrids.subscription.title') }}
</x-dialog.header>
<x-dialog.article>
    <x-helper>
        <p class="max-w-xl">{!! __('datagrids.subscription.helper', ['max' => '<code>100</code>']) !!}</p>
    </x-helper>

</x-dialog.article>
<x-dialog.footer>
    <a href="{{ route('settings.subscription', ['f' => 'datagrid']) }}" class="btn2 btn-primary">
        {{ __('datagrids.subscription.cta') }}
    </a>
</x-dialog.footer>

