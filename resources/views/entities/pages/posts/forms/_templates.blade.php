<div class="tab-pane" id="form-templates">
    <x-grid type="1/1">
        <x-helper>
            <p>{{ __('posts.create.template.helper') }}</p>
        </x-helper>
        <ul>
            @foreach ($templates as $id => $name)
                <li>
                    <a href="{{ route('entities.posts.create', [$campaign, $entity, 'template' => $id]) }}">
                        <span>{{$name}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </x-grid>
</div>
