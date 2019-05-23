<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Attribute $attribute
 */
$attributes = $model->entity->starredAttributes;
?>
@if (count($attributes) > 0)
    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">{{ trans('crud.tabs.attributes') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-group list-group-unbordered">
                @foreach ($attributes as $attribute)
                    <li class="list-group-item">
                        @if ($attribute->isCheckbox())
                            @if ($attribute->value)
                                <i class="fa fa-check pull-right"></i>
                            @else
                                <span class="pull-right">{{ __('voyager.generic.no') }}</span>
                            @endif
                        @elseif (!$attribute->isText())
                            <span class="pull-right">{{ $attribute->value }}</span>
                        @endif
                        <strong>{{ $attribute->name }}</strong>
                        @if ($attribute->isText())
                            <p>{{ $attribute->value }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@endif