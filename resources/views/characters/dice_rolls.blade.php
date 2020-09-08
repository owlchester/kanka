@extends('layouts.app', [
    'title' => trans('characters.dice_rolls.title', ['name' => $model->name]),
    'description' => trans('characters.dice_rolls.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => __('characters.index.title')],
        ['url' => route('characters.show', $model), 'label' => $model->name],
        trans('characters.show.tabs.dice_rolls')
    ],
    'mainTitle' => false,
    'miscModel' => $model,

])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('characters._menu', ['active' => 'dice_rolls'])
        </div>
        <div class="col-md-9">
            @include('characters.panels.dice_rolls')
        </div>
    </div>
@endsection
