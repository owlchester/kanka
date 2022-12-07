@includeWhen(request()->ajax(), 'partials.forms._modal')
@includeWhen(!request()->ajax(), 'partials.forms._panel')
