<?php /** @var \App\Models\Entity $entity */?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('abilities.show.tabs.entities') }}
        </h2>

        <p class="help-block">{{ trans('abilities.helpers.descendants') }}</p>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter')
            </div>
            <div class="col-md-6 text-right">

            </div>
        </div>

        <?php $r = $model->entities()->acl()->simpleSort($datagridSorter)->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('abilities.show.tabs.abilities') }}</p>
        <table id="abilities" class="table table-hover margin-top {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('crud.fields.entity') }}</th>
                <th>{{ trans('crud.fields.entity_type') }}</th>
                <th class="text-right">
                    @can('update', $model)
                        <a href="{{ route('abilities.entity-add', $model) }}" class="btn btn-primary btn-sm"
                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('abilities.entity-add', $model) }}">
                            <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('abilities.children.actions.add') }}</span>
                        </a>
                    @endcan
                </th>
            </tr>
            @foreach ($r as $entity)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $entity->getImageUrl(40) }}');" title="{{ $entity->name }}" href="{{ $entity->url('show') }}"></a>
                    </td>
                    <td>
                        {!! $entity->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ __('entities.' . $entity->pluralType()) }}
                    </td>
                    <td>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
