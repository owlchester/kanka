<?php /** @var \App\Models\Post $template */?>
<div class="tab-pane" id="form-templates">
    <x-grid type="1/1">
        <x-helper>
            <p>{{ __('posts/templates.helper') }}</p>
        </x-helper>
        <div class="flex flex-wrap items-center gap-2">
            @foreach ($templates as $template)
                <div class="join">
                    <a href="{{ route('entities.posts.create', [$campaign, $entity, 'template' => $template->id]) }}" class="btn2 btn-default btn-sm join-item">
                        <span>
                            {!! $template->name !!}
                        </span>
                    </a>
                    @can('post', [$template->entity, 'edit', $template])
                    <a href="{{ route('entities.posts.edit', [$campaign, $template->entity, $template]) }}" class="btn2 btn-default btn-sm join-item" data-tooltip data-title="{{ __('posts/templates.tooltips.click-to-edit') }}">
                        <x-icon class="edit"></x-icon>
                    </a>
                    @endcan
                </div>
            @endforeach

            <x-learn-more url="/features/articles.html#templates"></x-learn-more>
        </div>
    </x-grid>
</div>
