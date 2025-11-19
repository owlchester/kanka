
<x-form :action="['campaign-visibility.save', $campaign]">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/public.title'),
        'content' => 'campaigns.forms.modals._visibility-form',
        'save' => __('crud.actions.apply')
    ])
    @if (isset($from) && $from === 'overview')
        <input type="hidden" name="from" value="{{ $from }}" />
    @endif
</x-form>

