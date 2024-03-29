@if (!empty($model->type))
    <div class="element profile-type">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.type') }}</div>
        @php
        $defaultOptions = auth()->check() && auth()->user()->entityExplore === '1' ? [$campaign, 'm' => 'table'] : [$campaign];
        @endphp
        {!! link_to_route(
            $entity->pluralType() . '.index',
            $model->type,
            $defaultOptions + ['_clean' => true, 'type' => $model->type]
        ); !!}
    </div>
@endif
