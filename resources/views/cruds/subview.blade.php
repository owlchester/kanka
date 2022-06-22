@section('og')
    <meta property="og:description" content="{{ $model->ajaxTooltip() }}" />
    @if ($model->image)<meta property="og:image" content="{{ $model->getImageUrl(0)  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@inject('campaignService', 'App\Services\CampaignService')

@include($fullview)
