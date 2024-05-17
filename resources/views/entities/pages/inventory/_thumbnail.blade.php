@php /** @var \App\Models\Inventory $item **/ @endphp
@if ($item->item && $item->item->entity->hasImage())
    <div class="w-24 h-24 rounded-full cover-background" style="background-image: url('{{ \App\Facades\Avatar::entity($item->item->entity)->size(192)->thumbnail() }}')" >
    </div>
@elseif ($item->image)
    <div class="w-24 h-24 rounded-full cover-background" style="background-image: url('{{ $item->image->getUrl(192) }}')" >
    </div>
@else
    <div class="w-24 h-24 rounded-full bg-base-200 flex items-center justify-center align-center">
        <x-icon class="fa-duotone fa-gem text-6xl text-accent" />
    </div>
@endif
