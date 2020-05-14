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
            <div class="box-body">
                <h2 class="page-header with-border">
                    {{ trans('crud.tabs.mentions') }}
                </h2>

                <p class="help-block">{{ __('crud.helpers.mentions') }}</p>
            </div>
            <div class="box-footer">
                {{ $mentions->links() }}
            </div>
        </div>
    </div>
</div>
