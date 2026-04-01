<?php /** @var \App\Models\Item $model */?>
@if ($model->price)
{{ __('items.fields.price') }} | {{ $model->price }} |
@endif
@if ($model->size)
| {{ __('items.fields.size') }} | {{ $model->size }} |
@endif
@if ($model->weight)
| {{ __('items.fields.weight') }} | {{ $model->weight }} |
@endif
@include('entities.components.profile._location')
@if ($model->itemCreators->isNotEmpty())
| {{ __('items.fields.creators') }} | @foreach ($model->itemCreators as $itemCreator){!! $itemCreator->creator->name !!}@if (!$loop->last), @endif @endforeach |
@endif
@include('entities.pages.print.profile._type')
