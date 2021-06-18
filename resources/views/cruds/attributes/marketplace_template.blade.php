<?php
/**
 * @var \App\Models\Plugin $plugin
 */
?>

<div class="marketplace-template-{{ $plugin->plugin->uuid }}">
    {!! $plugin->version->content(isset($entity) ? $entity : $model->entity) !!}
</div>


@section('styles')
    @parent
    <style>
        {!! $plugin->version->css !!}
    </style>
@endsection
