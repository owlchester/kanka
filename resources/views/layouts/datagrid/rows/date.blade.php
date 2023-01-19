@if (!empty($model->date))app.php
    {{ \App\Facades\UserDate::format($model->date) }}
@endif
