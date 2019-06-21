<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('families.show.tabs.families') }}
        </h2>

        <p class="help-block">{{ trans('families.helpers.descendants') }}</p>

        <?php $r = $model->descendants()->with('parent')->orderBy('name', 'ASC')->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('families.show.tabs.families') }}</p>
        <table id="families" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('families.fields.name') }}</th>
                <th>{{ trans('crud.fields.family') }}</th>
                <th>{{ trans('crud.fields.location') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $model)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route('families.show', $model->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('families.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltipWithName() }}" data-html="true">{{ $model->name }}</a>
                    </td>
                    <td>
                        @if ($model->parent)
                            <a href="{{ route('families.show', $model->parent->id) }}" data-toggle="tooltip" title="{{ $model->parent->tooltipWithName() }}" data-html="true">{{ $model->parent->name }}</a>
                        @endif
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td>
                        @if ($model->location)
                            <a href="{{ $model->location->getLink() }}" data-toggle="tooltip" title="{{ $model->location->tooltipWithName() }}" data-html="true">{{ $model->location->name }}</a>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>