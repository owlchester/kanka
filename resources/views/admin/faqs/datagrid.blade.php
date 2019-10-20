<?php /** @var \App\Models\Faq $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ trans('faq.fields.locale') }}</th>
        <th>{{ trans('faq.fields.order') }}</th>
        <th>{{ trans('faq.fields.question') }}</th>
        <th>{{ trans('faq.fields.answer') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>{{ $model->locale }}</td>
            <td>{{ $model->order }}</td>
            <td>{{ $model->question }}</td>
            <td>{{ $model->answer }}</td>
            <td>
                <a href="{{ route('admin.faqs.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

