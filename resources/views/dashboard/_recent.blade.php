<div class="col-md-4 dashboard-box">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('dashboard.recent.title', ['name' => $title]) }}</h3>

            @can('create', $perm)
            <div class="box-tools pull-right">
                <a href="{{ route($route . '.create') }}" class="btn btn-primary btn-xs" title="{{ trans('dashboard.recent.add', ['name' => $title]) }}"><i class="fa fa-plus"></i></a>
            </div>
            @endcan
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="products-list product-list-in-box">
                @foreach ($models as $model)
                    <li class="item entity">
                        <div class="product-img">
                            <a style="background-image: url('{{ $model->getImageUrl(true) }}');" data-toggle="tooltip" title="{{ $model->tooltipWithName() }}" data-html="true" class="entity-image" href="{{ route($route . '.show', $model->id) }}"></a>
                        </div>
                        <div class="product-info">
                            <a href="{{ route($route . '.show', $model->id) }}" class="product-title" data-toggle="tooltip" title="{{ $model->tooltipWithName() }}" data-html="true" >{{ $model->name }}</a>
                            @if ($model->family)
                                <a href="{{ route('families.show', $model->family_id) }}" data-toggle="tooltip" data-html="true" title="{{ $model->family->tooltipWithName() }}">{{ $model->family->name }}</a>
                            @endif
                            <span class="pull-right product-description">{{ $model->updated_at->diffForHumans() }}</span>
                            <p class="text-justify entity-short">
                                {{ $model->tooltip(250, false) }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if (count($models) == 0)
                <p><i>{{ trans('dashboard.recent.no_entries') }}</i></p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
            <a href="{{ route($route . '.index') }}" class="uppercase">{{ trans('dashboard.recent.view', ['name' => $title]) }}</a>
        </div>
        <!-- /.box-footer -->
    </div>
</div>