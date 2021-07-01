<?php /** @var \App\Models\Faq $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('faq.fields.category') }}</th>
        <th>{{ __('faq.fields.order') }}</th>
        <th>{{ __('faq.fields.question') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>{{ $model->category->title }}</td>
            <td>{{ $model->order }}</td>
            <td>

                @if (!$model->is_visible)
                    <i class="fas fa-eye-slash"></i>
                @endif
                <a href="{{ route('admin.faqs.edit', $model) }}">
                {{ $model->question }}
                </a>
            </td>
            <td>
                <a href="{{ route('admin.faqs.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

