@if ($model->entity && !empty($model->entity->header_image) && $campaign->campaign()->boosted())
    @section('entity-header')
        <div class="entity-header" style="background-image: url('{{ $model->entity->getImageUrl(0, 0, 'header_image') }}');">
            <div class="bottom">
                @if ($model->image)
                    <a class="entity-avatar" href="{{ $model->getImageUrl(0) }}" title="{{ $model->name }}" target="_blank">
                        <img src="{{ $model->getImageUrl(0) }}" alt="{{ $model->name }} picture">
                    </a>
                @endif
                <div class="texts">
                    <h1>
                        {{ $model->name }}
                        @if ($model->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}"></i>
                        @endif
                        @if ($model instanceof \App\Models\Character && $model->is_dead)
                            <span class="ra ra-skull" title="{{ __('characters.hints.is_dead') }}"></span>
                        @endif
                    </h1>
@if ($model instanceof \App\Models\Character && $model->title)
                    <h3 class="title">{{ $model->title }}</h3>
@endif
                </div>
            </div>
        </div>
    @endsection
@endif
