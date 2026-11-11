@extends('layouts.app', [
    'title' => __('campaigns/modules.rename.title', ['module' => $entityType->plural()]),
    'breadcrumbs' => [['url' => route('campaign.modules', $campaign), 'label' => __('campaigns/categories.tab')], $entityType->plural()],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    <x-form :action="['entity_types.update', $campaign, $entityType]" method="PATCH" files :extra="['data-category-form' => '1']">
        @include('campaigns.entity-types._editor')
    </x-form>
@endsection
