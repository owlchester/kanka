    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="">
            @if($image->isFolder())
                <div class="text-center my-5">
                    <x-icon class="fa-regular fa-folder fa-4x" />
                </div>
            @else

                @if ($image->hasThumbnail())
                    <div class="text-center">
                        <img src="{{ $image->getUrl(192, 144) }}" class="max-w-full rounded" alt="{{ $image->name }}" />
                    </div>
                @else
                    <x-helper>
                        <p>This file can't be previewed.</p>
                    </x-helper>
                @endif

                <hr />

                <div class="grid grid-cols-1 gap-5">
                    @if (!$image->isFont())
                        <p class="{{ $image->inEntitiesCount() === 0 ? 'text-muted' : '' }} m-0">
                            {{ trans_choice('campaigns/gallery.fields.image_used_in', $image->inEntitiesCount(), ['count' => $image->inEntitiesCount()]) }}
                        </p>
                        @if($image->inEntitiesCount() > 0)
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($image->inEntities() as $entity)
                                    <a href="{{ $entity->url() }}">{{ $entity->name }}</a>
                                @endforeach
                            </div>
                        @endif
                    @endif

                    @if($image->mentions->count() > 0)
                        <p class="{{ $image->mentions->count() === 0 ? 'text-muted' : '' }} m-0">
                            {{ trans_choice('campaigns/gallery.fields.image_mentioned_in', $image->mentions->count(), ['count' => $image->mentions->count()]) }}
                        </p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($image->mentions as $mention)
                                @if($mention->isPost())
                                    <a href="{{ $mention->entity->url() }}?#post-{{ $mention->post_id }}"> {{ $mention->post->name }}</a>
                                @else
                                    <a href="{{ $mention->entity->url() }}">{{ $mention->entity->name }}</a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <x-grid type="1/1">
            <div class="flex gap-2 items-center flex-wrap">
                @if(!$image->isFolder())
                    <x-badge :title="__('campaigns/gallery.fields.ext')">
                        <x-icon class="fa-regular fa-image" />
                        {{ strtoupper($image->ext) }}
                    </x-badge>
                    <x-badge :title="__('campaigns/gallery.fields.size')">
                        <x-icon class="fa-regular fa-weight-hanging" />
                        {{ $image->niceSize() }}
                    </x-badge>
                @endif
                <x-badge :title="__('campaigns/gallery.fields.created_by')" css="text-xs">
                    <x-icon class="fa-regular fa-user" />
                    <div class="text-ellipsis truncate">
                        {{ $image->user ? $image->user->name : __('crud.users.unknown') }}
                    </div>
                </x-badge>
            </div>

            @can('edit', [$image, $campaign])
            <x-forms.field field="name" :label="__('crud.fields.name')" required>
                <input type="text" name="name" maxlength="45" required value="{!! htmlspecialchars(old('name', $image->name ?? null)) !!}" />
            </x-forms.field>

            @if(!$image->isFolder())
                <x-forms.field field="folder" :label="__('campaigns/gallery.fields.folder')">
                    <x-forms.select name="folder_id" :options="$folders" :selected="$image->folder_id ?? null" />
                </x-forms.field>
            @endif

            @include('cruds.fields.visibility_id', ['model' => $image])
            @endcan
        </x-grid>
    </div>
