@section('og')
    <meta property="og:description" content="{{ $model->tooltip() }}" />
    @if ($model->image)<meta property="og:image" content="{{ $model->getImageUrl(0)  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@inject('campaign', 'App\Services\CampaignService')

@include('entities.components.header', [
    'model' => $model,
    'breadcrumb' => [
        ['url' => Breadcrumb::index($model->entity->pluralType()), 'label' => __($model->entity->pluralType() . '.index.title')],
        __($model->entity->pluralType() . '.show.tabs.' . $view)
    ]
])

@include($fullview)
