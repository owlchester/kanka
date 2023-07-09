@includeWhen(request()->ajax() && !isset($dialog), 'partials.forms._modal')
@includeWhen(request()->ajax() && isset($dialog), 'partials.forms._dialog')
@includeWhen(!request()->ajax(), 'partials.forms._panel')
