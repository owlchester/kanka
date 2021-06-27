<?php /** @var \App\Models\FaqCategory $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th class="avatar">#</th>
        <th>{{ __('crud.fields.name') }}</th>
        <th>{{ __('admin/faqs.categories.fields.questions') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td class="avatar">
                # {{ $model->order }}
            </td>
            <td>
                @if (!$model->is_visible)
                    <i class="fas fa-eye-slash"></i>
                @endif
                <a href="{{ route('admin.faq-categories.edit', $model) }}">
                    {{ $model->title }}
                </a>
            </td>
            <td>{{ $model->faqs->count() }}</td>
            <td class="text-right">
                <a href="{{ route('admin.faq-categories.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

