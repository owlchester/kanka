@php
 /** @var \App\Models\Whiteboard $model */
@endphp
<a href="{{ route('whiteboards.draw', [$campaign, $model->id]) }}" target="_blank"
   data-toggle="tooltip" data-title="{{ __('whiteboards.actions.draw') }}">
    <x-icon class="fa-regular fa-chalkboard" />
</a>
