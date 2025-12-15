<x-grid type="1/1">
    @if (!empty($races))
        <x-helper>
            <p>{!! __('entities/abilities.import.helper', ['name' => $entity->name]) !!}</p>
        </x-helper>
        <ul>
            @foreach ($races as $name => $count)
                <li> 
                    <span>{!! trans_choice('entities/abilities.import.race_abilities', $count, ['name' => $name, 'count' => $count]) !!}</span>
                </li>
            @endforeach
        </ul>
    @else 
        <x-helper>
            <p>{!! __('entities/abilities.import.no_abilities', ['name' => $entity->name]) !!}</p>
        </x-helper>
    @endif
</x-grid>
