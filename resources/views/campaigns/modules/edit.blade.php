{!! Form::open(['method' => 'PATCH', 'route' => ['modules.update', [$campaign, $entityType->id]], 'class' => 'w-full max-w-lg']) !!}
@include('partials.forms.form', [
    'title' => __('campaigns/modules.rename.title', ['module' => __('entities.' . $entityType->code)]),
    'content' => 'campaigns.modules._form',
    'dialog' => true,
])
{!! Form::close() !!}

