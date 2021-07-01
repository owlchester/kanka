<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
@if(!$campaign->campaign()->boosted())

    <div class="visu-teaser text-center">
        <a href="{{ route('front.pricing', '#boost') }}" target="_blank">
            {!! __('entities/relations.teaser') !!}
        </a>
    </div>
    <?php return ?>
@endif

{!! Form::open([
    'route' => ['entities.relations.index', $entity],
    'method' => 'GET',
]) !!}
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-3">
                {!! Form::hidden('relations', 0) !!}
                <label>
                    {!! Form::checkbox('relations', 1, request()->get('relations', true)) !!}
                    {{ __('entities/relations.filters.relations') }}
                </label>
            </div>
            <div class="col-sm-3">
                {!! Form::hidden('related', 0) !!}
                <label>
                    {!! Form::checkbox('related', 1, request()->get('related', true)) !!}
                    {{ __('entities/relations.filters.related') }}
                </label>
            </div>
            <div class="col-sm-3">
                {!! Form::hidden('mentions', 0) !!}
                <label>
                    {!! Form::checkbox('mentions', 1, request()->get('mentions', false)) !!}
                    {{ __('entities/relations.filters.mentions') }}
                </label>
            </div>
            <div class="col-sm-3 text-right">
                <button class="btn btn-primary">
                    {{ __('entities/relations.filters.submit') }}
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<div class="box box-solid box-entity-relations box-entity-relations-explorer">
    <div class="box-body">
    <div class="loading text-center" id="spinner">
        <i class="fa fa-spinner fa-spin fa-4x"></i>
    </div>
    <div id="cy" class="cy" style="display: none;" data-url="{{ route('entities.relations_map', array_merge([$entity], $options)) }}"></div>

    </div>
</div>


@section('scripts')
    <script src="/vendor/spectrum/spectrum.js" defer></script>
    <script src="{{ mix('js/relations.js') }}" defer></script>
@endsection

@section('styles')
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">
    <link href="{{ mix('css/relations.css') }}" rel="stylesheet">
@endsection
