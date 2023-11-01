@section('og')
    @if ($tooltip = $model->entity->mappedPreview())<meta property="og:description" content="{{ $tooltip }}" />@endif
    @if ($model->entity->image_path)<meta property="og:image" content="{{ \App\Facades\Avatar::entity($model->entity)->size(200)->thumbnail()  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@include($fullview)
