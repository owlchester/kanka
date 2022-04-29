<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>


<table id="entity_relations" class="table table-hover">
    <thead>
    <tr>
        <th>
            {{ __('entities/relations.fields.relation') }}
        </th>
        <th class="avatar"><br></th>
        <th>
            {{ __('crud.relations.fields.name') }}
        </th>
        <th class="hidden-xs hidden-sm">
            {{ __('crud.fields.location') }}
        </th>
        <th class="hidden-xs hidden-sm">
            {{ __('entities/relations.fields.attitude') }}
        </th>
        @if (auth()->check())
            <th>
                <span class="hidden-xs hidden-sm">
                {{ __('crud.fields.visibility') }}
                </span>
            </th>
        @endif
        <th class="text-right">
            <br />
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ([] as $relation)
        @if(!$relation->target)
            @continue
        @endif
        <tr data-entity-id="{{ $relation->target->id }}" data-entity-type="{{ $relation->target->type() }}">
            <td class="breakable">
                @if ($relation->is_star)
                    <i class="fas fa-star" title="{{ __('crud.fields.is_star') }}" data-toggle="tooltip"></i>
                @endif
                {{ $relation->relation }}
            </td>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->target->child->getImageUrl(40) }}');" title="{{ $relation->target->child->name }}" href="{{ $relation->target->url() }}"></a>
            </td>
            <td>
                {!! $relation->target->tooltipedLink() !!}
            </td>
            <td class="hidden-xs hidden-sm">
                @if (isset($relation->target->child->location_id) && !empty($relation->target->child->location))
                    {!! $relation->target->child->location->tooltipedLink() !!}
                @endif
            </td>
            <td class="breakable hidden-xs hidden-sm">
                @if (!empty($relation->colour))
                    <div class="label-tag-bubble" style="background-color: {{ $relation->colour }}; "></div>
                @endif
                {{ $relation->attitude }}
            </td>
            @if (Auth::check())
                <td>
                    @include('cruds.partials.visibility', ['model' => $relation])
                </td>
            @endif
            <td class="text-right">
                @can('relation', [$entity->child, 'edit'])
                    <a href="{{ route('entities.relations.edit', [$entity, 'relation' => $relation, 'mode' => 'table']) }}" class="btn btn-xs btn-primary"
                       data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.edit', [$entity, 'relation' => $relation, 'mode' => 'table']) }}"
                       title=" {{ __('crud.edit') }}"
                    >
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan
                @can('relation', [$entity->child, 'delete'])
                    <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $relation->target->name }}"
                            data-target="#delete-confirm" data-delete-target="delete-form-{{ $relation->id }}"


                            data-mirrored="{{ $relation->mirrored() }}"


                            title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.relations.destroy', $entity, 'relation' => $relation], 'style' => 'display:inline', 'id' => 'delete-form-' . $relation->id]) !!}
                    {!! Form::hidden('remove_mirrored', 0) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
