
{!! Form::model($campaign, ['route' => ['campaign-visibility.save', $campaign], 'method' => 'POST']) !!}
@include('partials.forms.form', [
    'title' => __('campaigns/public.title'),
    'content' => 'campaigns.forms.modals._public-form',
    'dialog' => true,
    'save' => __('crud.actions.apply')
])
@if (isset($from) && $from === 'overview')
    <input type="hidden" name="from" value="{{ $from }}" />
@endif
{!! Form::close() !!}

