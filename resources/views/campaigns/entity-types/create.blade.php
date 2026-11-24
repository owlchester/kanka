@extends('layouts.app', [
    'title' => __('campaigns/modules.create.title'),
    'breadcrumbs' => [['url' => route('campaign.modules', $campaign), 'label' => __('campaigns/categories.tab')], __('campaigns/modules.create.title')],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    <x-form :action="['entity_types.store', $campaign]" method="POST" files :extra="['data-category-form' => '1']">
        @include('campaigns.entity-types._editor')
    </x-form>
@endsection
