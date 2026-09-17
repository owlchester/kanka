## {!! __('crud.tabs.inventory') !!}

| {!! __('entities/inventories.fields.position') !!} | {!! __('entities/inventories.fields.name') !!} | {!! __('entities/inventories.fields.amount') !!} | {!! __('items.fields.price') !!} / {!! __('items.fields.size') !!} / {!! __('items.fields.weight') !!} | {!! __('entities/inventories.fields.description') !!} |
|:-|:-:|:-:|:-:|:-|
@foreach ($entityData['inventory'] as $item)
| {!! $item['position'] !!} | @if ($item['url']) [{!! $item['name'] !!}]({!! $item['url'] !!}) @else {!! $item['name'] !!} @endif @if ($item['equipped']) ({!! __('entities/inventories.fields.is_equipped') !!}) @endif | {!! $item['amount'] !!} | {!! implode(' / ', array_filter([$item['price'], $item['size'], $item['weight']])) !!} | {!! $converter->convert((string) $item['description']) !!} |
@endforeach
