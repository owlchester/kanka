@php $boosted = $campaign->boosted() @endphp

<x-grid>
    @include('dashboard.widgets.forms._name')

    @include('dashboard.widgets.forms._size')

    @include('cruds.fields.entity', [
        'label' => __('dashboard.widgets.fields.optional-entity'),
        'preset' => isset($model) && $model->target instanceof \App\Models\Entity ? $model->target : null,
    ])
    
    @include('dashboard.widgets.forms._width')
</x-grid>


<x-widgets.forms.advanced>
    @include('dashboard.widgets.forms._class')
</x-widgets.forms.advanced>
