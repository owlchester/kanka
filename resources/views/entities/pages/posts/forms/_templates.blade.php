<div class="tab-pane" id="form-templates">
    <x-grid type="1/1">
        <x-helper>
            <p>{{ __('posts/templates.helper') }}</p>
        </x-helper>
        <div class="flex flex-wrap items-center gap-2">
            @foreach ($templates as $id => $name)
                <a href="{{ route('entities.posts.create', [$campaign, $entity, 'template' => $id]) }}" class="px-4 py-2 border border-base-200 hover:bg-base-200 bg-base-100 rounded-xl">
                    <span>{{$name}}</span>
                </a>
            @endforeach
        </div>
    </x-grid>
</div>
