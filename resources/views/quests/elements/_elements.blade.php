<?php /** @var \App\Models\QuestElement[] $elements */?>
@php $count = 0; @endphp

<div class="row">
    <div class="col-md-6">
        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#entity-main-block'])
    </div>
</div>

<div class="mt-6" id="quest-elements">
    <div class="row">
    @foreach ($elements as $element)
        @if ($element->entity_id && !$element->entity)
            @continue
        @endif
        @if ($count % 2 === 0)
    </div><div class="row">
        @endif
        @php $count++; @endphp
        <div class="col-md-6">
            <div class="box box-widget widget-user-2 box-quest-element" id="quest-element-{{ $element->id }}" @if ($element->entity)data-entity-id="{{ $element->entity->id }}" data-entity-type="{{ $element->entity->type() }}"@endif>
                <div class="flex p-5 gap-3 items-center {{ $element->colourClass() }}">
                    @if ($element->entity)
                        <div class="widget-user-image">
                            <img class="flex-none entity-image rounded-full pull-left" src="{{ $element->entity->avatarSize(40)->avatarV2() }}" title="{{ $element->entity->name }}" alt="{{ $element->entity->name }}" />
                        </div>
                    @endif

                    <div class="flex-grow">
                        <h3 class="widget-user-username m-0 text-2xl">
                            @if($element->entity)
                                @if ($element->entity->is_private)
                                    <i class="fa-solid fa-lock" aria-hidden="true" aria-label="{{ __('crud.is_private') }}" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                                @endif
                                {!! $element->entity->tooltipedLink($element->name) !!}
                            @else
                                <span class="name">
                                    {!! $element->name !!}
                                </span>
                            @endif
                        </h3>
                        @if (!empty($element->role))
                            <h5 class="m-0">{!! $element->role !!}</h5>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <p>{!! $element->entry() !!}</p>
                </div>
                <div class="box-footer text-right clearfix">
                    <div class="pull-left">
                        {!! $element->visibilityIcon() !!}
                    </div>
                    @can('update', $model)
                        <a href="{{ route('quests.quest_elements.edit', [$model, $element]) }}" class="btn btn-xs btn-primary">
                            <i class="fa-solid fa-edit" title="{{ __('crud.edit') }}"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $element->name() }}"
                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $element->id }}"
                                title="{{ __('crud.remove') }}">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => [
                                'quests.quest_elements.destroy',
                                $model,
                                $element
                            ],
                            'style'=>'display:inline',
                            'id' => 'delete-form-' . $element->id
                        ]) !!}
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>

<div class="text-right">
    {!! $elements->fragment('quest-elements')->links() !!}
</div>
