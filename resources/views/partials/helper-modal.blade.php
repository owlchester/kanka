<x-dialog :id="$id" :title="$title">
    @foreach ($textes as $text)
        <p class="m-3 text-justify">{!! $text !!}</p>
    @endforeach
</x-dialog>
