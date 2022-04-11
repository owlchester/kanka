<?php
/**
 * @var \App\Models\Organisation $model
 * @var \App\Models\Organisation $r
 */
?><div class="box box-solid" id="organisation-suborganisations">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('organisations.show.tabs.organisations') }}
        </h3>

        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
        </div>
    </div>
    <div class="box-body">

    <div class="row">
        <div class="col-md-6 col-sm-12">
            @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#organisation-suborganisations'])
        </div>
    </div>

    <?php $r = $model->descendants()->with('parent')->simpleSort($datagridSorter)->paginate(); ?>

        <table id="organisations" class="table table-hover ">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('organisations.fields.name') }}</th>
                    <th>{{ __('organisations.fields.type') }}</th>
                    <th>{{ __('crud.fields.organisation') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($r as $model)
                <tr class="{{ $model->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ route('organisations.show', $model->id) }}"></a>
                    </td>
                    <td>
                        @if ($model->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $model->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $model->type }}
                    </td>
                    <td>
                        @if ($model->parent)
                            {!! $model->parent->tooltipedLink() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('organisation-suborganisations')->links() }}
        </div>
    @endif
</div>

