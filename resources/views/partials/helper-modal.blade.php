<x-dialog :id="$id" :title="$title">
    <x-grid type="1/1">
        @foreach ($textes as $text)
            <p class="text-justify">{!! $text !!}</p>
        @endforeach
    </x-grid>
</x-dialog>
