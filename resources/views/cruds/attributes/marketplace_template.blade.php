<?php
/**
 * @var \App\Models\Plugin $plugin
 */
$one = 'yoooo';
?>


<div class="marketplace-template-{{ $plugin->plugin->uuid }}">
    {!! $plugin->version->content($model->entity) !!}
</div>


@section('styles')
    @parent
    <style>
    {!! $plugin->version->css !!}
    </style>
@endsection
