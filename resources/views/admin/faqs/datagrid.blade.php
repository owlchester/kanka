<?php /** @var \App\Models\Faq $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('Category') }}</th>
        <th>{{ __('Order') }}</th>
        <th>{{ __('Question') }}</th>
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
            <td class="text-right">
                <a href="{{ route('admin.faqs.edit', $model) }}" class="margin-r-5">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

