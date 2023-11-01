    {!! Form::model($campaign, ['route' => ['campaign-applications.save', $campaign], 'method' => 'POST', 'class' => 'text-left w-full max-w-lg']) !!}
    @include('partials.forms.form', [
        'title' => __('campaigns/submissions.toggle.title'),
        'content' => 'campaigns.submissions._toggle_form',
        'save' => __('crud.actions.apply'),
        'dialog' => true,
    ])
    {!! Form::close() !!}
