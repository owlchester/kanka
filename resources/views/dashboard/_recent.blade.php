<div class="col-md-4">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('dashboard.recent.title', ['name' => $title]) }}</h3>

            <div class="box-tools pull-right">
                <a href="{{ route($route . '.create') }}" class="btn btn-primary btn-xs" title="{{ trans('dashboard.recent.add', ['name' => $title]) }}"><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="products-list product-list-in-box">
                @foreach ($models as $model)
                    <li class="item">
                        <div class="product-img">
                            <img src="{{ $model->getImageUrl(true) }}" title="{{ $model->name }} Image" alt="{{ $model->name }} Image">
                        </div>
                        <div class="product-info">
                            <a href="{{ route($route . '.show', $model->id) }}" class="product-title">{{ $model->name }}</a>
                            <span class="pull-right product-description">{{ $model->elapsed() }}</span>
                            <p class="text-justify">
                                {{ $model->shortHistory() }}
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