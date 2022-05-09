@inject('dateRenderer', 'App\Renderers\DateRenderer')

{{ $dateRenderer->render($model->date) }}
