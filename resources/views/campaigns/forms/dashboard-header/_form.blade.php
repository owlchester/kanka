@include('campaigns.forms.panes.dashboard', ['model' => $campaign])

@if(!request()->ajax())
@include('editors.editor')
@endif
