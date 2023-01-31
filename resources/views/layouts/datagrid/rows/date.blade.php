@if (!empty($model->date))
    {{ \App\Facades\UserDate::format($model->date) }}
@endif
