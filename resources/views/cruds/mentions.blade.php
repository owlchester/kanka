@section('og')
<meta property="og:description" content="{{ $model->tooltip() }}" />
@if ($model->image)<meta property="og:image" content="{{ $model->getImageUrl(0)  }}" />@endif

<meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@inject('campaign', 'App\Services\CampaignService')

<div class="row">
    <div class="col-md-3">
        @include($viewPath . '._menu')
    </div>

    <div class="col-md-9">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    {{ trans('crud.tabs.mentions') }}
                </h3>
            </div>
            <div class="box-body">

                <p class="help-block">{{ __('crud.helpers.mentions') }}</p>
            </div>
            <div class="box-footer text-right">
                {{ $mentions->links() }}
            </div>
        </div>
    </div>
</div>
