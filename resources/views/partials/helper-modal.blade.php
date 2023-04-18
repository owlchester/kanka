<x-dialog :id="$id" :title="$title">
    @foreach ($textes as $text)
        <p class="mb-2 text-justify">{!! $text !!}</p>
    @endforeach
</x-dialog>
