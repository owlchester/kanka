@extends('layouts.app', [
    'title' => __('dice_roll_results.index.title'),
    'seoTitle' =>  __('dice_roll_results.index.title') . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-dice-roll-results',
])

@section('entity-header')
    <div class="flex gap-2 items-center mb-5">
        <h1 class="grow text-4xl category-title truncate">{!! __('dice_roll_results.index.title') !!}</h1>
        <div class="flex flex-wrap gap-2 justify-end">
            <a href="{{ route('dice_rolls.index', $campaign) }}" class="btn2 btn-">
                <x-icon class="fa-solid fa-square"></x-icon>
                {{ __('entities.dice_rolls') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    @include('partials.errors')

    @include('ads.top')

    <div class="flex flex-col gap-5">
        <div class="flex gap-1 items-start">
            <x-box :padding="false" >
                <div class="table-responsive">
                    <table class="table table-striped table-entities">
                        <thead>
                            <tr>
                                <th >{{ __('entities.dice_roll') }}</th>
                                <th>{{ __('entities.character') }}</th>
                                <th>{{ __('crud.fields.creator') }}</th>
                                <th>{{ __('dice_rolls.fields.results') }}</th>
                                <th>{{ __('dice_rolls.results.fields.date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($models as $model)
                            <tr>
                                <td>
                                    <x-entity-link :entity="$model->diceRoll->entity" :campaign="$campaign" />
                                </td>
                                <td>
                                    <x-entity-link :entity="$model->diceRoll->character->entity" :campaign="$campaign" />
                                </td>
                                <td>
                                    {!! $model->user->name !!}
                                </td>
                                <td>
                                    {!! number_format($model->results) !!}
                                </td>
                                <td>
                                    <span title="{{ $model->updated_at }} UTC">
                                    {{ $model->updated_at->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-box>
        </div>


        @if($models->hasPages())
            <div class="">
                {{ $models->onEachSide(0)->links() }}
            </div>
        @endif
    </div>
@endsection
