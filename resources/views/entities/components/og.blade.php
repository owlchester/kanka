@php /** @var \App\Models\Entity $entity */ @endphp
@section('og')
    @if ($tooltip = $entity->mappedPreview())<meta property="og:description" content="{{ $tooltip }}" />@endif
    @if ($entity->hasImage())<meta property="og:image" content="{{ \App\Facades\Avatar::entity($entity)->size(276)->thumbnail()  }}" />@endif
    <meta property="og:url" content="{{ $entity->url()  }}" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection
