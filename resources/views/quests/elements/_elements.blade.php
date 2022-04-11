<?php /** @var \App\Models\QuestElement[] $elements */?>
@php $count = 0; @endphp

<div class="row">
    <div class="col-md-6">
        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#entity-main-block'])
    </div>
</div>

<div class="margin-top" id="quest-elements">
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
                <div class="widget-user-header {{ $element->colourClass() }}">
                    @if ($element->entity)
                        <div class="widget-user-image">
                            <div class="entity-image" style="background-image: url('{{ $element->entity->avatar(true) }}')" title="{{ $element->entity->name }}">
                            </div>
                        </div>
                    @endif

                    <h3 class="widget-user-username">
                        @if ($element->is_private)
                            <i class="fas fa-lock pull-right" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        @if($element->entity)
                            {!! $element->entity->tooltipedLink($element->name) !!}
                        @else
                            <span class="name">
                                            {!! $element->name !!}
                                        </span>
                        @endif
                    </h3>
                    <h5 class="widget-user-desc">{!! $element->role !!}<br /></h5>
                </div>
                <div class="box-body">
                    <p>{!! $element->entry() !!}</p>
                </div>
                <div class="box-footer text-right">
                    <div class="pull-left">
                        @include('cruds.partials.visibility', ['model' => $element])
                    </div>
                    @can('update', $model)
                        <a href="{{ route('quests.quest_elements.edit', [$model, $element]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit" title="{{ __('crud.edit') }}"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $element->name() }}"
                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $element->id }}"
                                title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
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
