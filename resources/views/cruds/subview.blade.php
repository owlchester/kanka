@section('og')
    <meta property="og:description" content="{{ $model->tooltip() }}" />
    @if ($model->image)<meta property="og:image" content="{{ Storage::url($model->image)  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@inject('campaign', 'App\Services\CampaignService')

@include($fullview)
