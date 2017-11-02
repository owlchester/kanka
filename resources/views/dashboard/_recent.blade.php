<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Recently Modified {{ $title }}</h3>

            <!--<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>-->
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
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
            <a href="{{ route($route . '.index') }}" class="uppercase">View All {{ $title }}</a>
        </div>
        <!-- /.box-footer -->
    </div>
</div>