<x-dialog :id="$id" :title="$title">
    @foreach ($textes as $text)
        <p class="text-justify">{!! $text !!}</p>
    @endforeach
</x-dialog>
