<?php /** @var \App\Models\Entity $entity */?>
<div class="box box-solid" id="ability-entities">
    <div class="box-body">
        <p class="help-block">{{ __('abilities.helpers.descendants') }}</p>

        <div class="row">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#ability-entities'])
            </div>
            <div class="col-md-6 text-right">

            </div>
        </div>

        <?php $r = $model->entities()->acl()->simpleSort($datagridSorter)->paginate(); ?>
        <table id="abilities" class="table table-hover margin-top ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('crud.fields.entity') }}</th>
                <th>{{ __('crud.fields.entity_type') }}</th>
            </tr>
            @foreach ($r as $entity)
                <tr class="@if ($entity->is_private) entity-private @endif">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $entity->avatar(true) }}');" title="{{ $entity->name }}" href="{{ $entity->url('show') }}"></a>
                    </td>
                    <td>
                        @if ($entity->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $entity->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ __('entities.' . $entity->pluralType()) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('ability-entities')->links() }}
        </div>
    @endif
</div>
