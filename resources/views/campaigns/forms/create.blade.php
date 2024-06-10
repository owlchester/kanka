@extends('layouts.app', [
    'title' => __('campaigns.create.title'),
    'breadcrumbs' => false,
    'skipBannerAd' => true,
    'startUI' => $start,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <x-form :action="['create-campaign']" files class="entity-form" unsaved>
    @include('campaigns.forms.standard')
    </x-form>
@endsection


@include('editors.editor')

