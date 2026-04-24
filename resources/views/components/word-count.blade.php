<div class="word-count text-xs text-neutral-content text-right @if (!config('app.debug')) hidden @endif">
    {{ __('crud.fields.word-count', ['number' => \Illuminate\Support\Number::format($count ?? 0)]) }}
</div>
