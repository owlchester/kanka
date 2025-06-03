@includeWhen(request()->ajax(), 'partials.forms._dialog')
@includeWhen(!request()->ajax(), 'partials.forms._panel')
