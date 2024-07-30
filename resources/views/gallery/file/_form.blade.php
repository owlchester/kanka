    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="">
            @if($image->isFolder())
                <div class="text-center my-5">
                    <x-icon class="fa-solid fa-folder fa-4x"></x-icon>
                </div>
            @else

                @if ($image->isFont())
                    <x-helper text="This file is a font file." />
                @else
                    <div class="text-center">
                        <img src="{{ $image->getUrl(192, 144) }}" class="max-w-full rounded" alt="{{ $image->name }}" />
                    </div>
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
                        <x-icon class="fa-regular fa-image"></x-icon>
                        {{ strtoupper($image->ext) }}
                    </x-badge>
                    <x-badge :title="__('campaigns/gallery.fields.size')">
                        <x-icon class="fa-regular fa-weight-hanging"></x-icon>
                        {{ $image->niceSize() }}
                    </x-badge>
                @endif
                <x-badge :title="__('campaigns/gallery.fields.created_by')" css="text-xs">
                    <x-icon class="fa-regular fa-user"></x-icon>
                    <div class="text-ellipsis truncate">
                        {{ $image->user ? $image->user->name : __('crud.users.unknown') }}
                    </div>
                </x-badge>
            </div>

            @can('edit', [$image, $campaign])
            <x-forms.field field="name" :label="__('crud.fields.name')" :required="true">
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
