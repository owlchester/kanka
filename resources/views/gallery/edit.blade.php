<?php /** @var \App\Models\Image $image */
$imageCount = 0;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('campaigns/gallery.actions.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">{!! $image->name !!}</h4>
</div>
<div class="modal-body panel-image-edit">
    <div class="gallery-toggle collapse !visible in">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="">
            @if($image->isFolder())
                <div class="text-center my-5">
                    <x-icon class="fa-solid fa-folder fa-4x"></x-icon>
                </div>
            @else

                @if ($image->isFont())
                    <div class="help-block">This file is a font file.</div>
                @else
                    <div class="text-center">
                        <img src="{{ $image->getUrl(192, 144) }}" class="max-w-full rounded" alt="{{ $image->name }}" />
                    </div>
                @endif

                <div class="mt-4">
                    <a href="#" class="btn btn-default btn-sm" data-toggle="collapse" data-target=".gallery-toggle">{{ __('campaigns/gallery.actions.focus_point') }}</a>
                </div>
                <hr />
                <p class="{{ $image->inEntitiesCount() === 0 ? 'text-muted' : '' }}">
                    {{ trans_choice('campaigns/gallery.fields.image_used_in', $image->inEntitiesCount(), ['count' => $image->inEntitiesCount()]) }}
                </p>
                @if($image->inEntitiesCount() > 0)
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($image->inEntities() as $entity)
                            <a href="{{ $entity->url() }}">{{ $entity->name }}</a>
                        @endforeach
                    </div>
                    <hr class="visible-sm visible-xs"/>
                @endif
            @endif
            </div>
            <div class="">
                <div class="flex gap-2 items-center mb-5">
                    @if(!$image->isFolder())
                        <div class="label label-default text-xs" title="{{ __('campaigns/gallery.fields.ext') }}">
                            <x-icon class="fa-regular fa-image"></x-icon>
                            {{ strtoupper($image->ext) }}
                        </div>
                        <div class="label label-default text-xs" title="{{ __('campaigns/gallery.fields.size') }}">
                            <x-icon class="fa-regular fa-weight-hanging"></x-icon>
                            {{ $image->niceSize() }}
                        </div>
                    @endif
                    <div class="label label-default text-xs" title="{{ __('campaigns/gallery.fields.created_by') }}">
                        <x-icon class="fa-regular fa-user"></x-icon>
                        {{ $image->user ? $image->user->name : __('crud.users.unknown') }}
                    </div>
                </div>

                {!! Form::model($image, ['route' => ['images.update', $image], 'method' => 'PUT', 'class' => '']) !!}

                <div class="form-group">
                    <label for="name" class="control-label required">{{ __('crud.fields.name') }}</label>
                    {!! Form::text('name', null, ['maxlength' => 45, 'class' => 'form-control']) !!}
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-5">
                @if(!$image->isFolder())
                    <div class="form-group">
                        <label for="folder_id" class="control-label">{{ __('campaigns/gallery.fields.folder') }}</label>
                        {!! Form::select('folder_id', $folders, null, ['class' => 'form-control']) !!}
                    </div>
                @endif

                @include('cruds.fields.visibility_id', ['model' => $image])
            </div>

            <div class="flex gap-2 sm:gap-5 items-center mb-5">
                <div class="grow flex gap-2 sm:gap-5">
                @if(!$image->isFolder() || $image->hasNoFolders())
                    <a role="button" tabindex="0" class="btn-dynamic-delete text-red-500 hover:text-red-800" data-toggle="popover"
                    title="{{ __('crud.remove') }}"
                    data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                    <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-confirm-form'>{{ __('crud.remove') }}</a>">
                        <x-icon class="fa-regular fa-trash"></x-icon>
                        {{ __('crud.remove') }}
                    </a>
                @endif
                    @if(!$image->isFolder())
                        <a href="{{ $image->getUrl() }}" target="_blank">
                            <x-icon class="fa-regular fa-link"></x-icon>
                            {{ __('campaigns/gallery.actions.' . $image->isFont() ? 'file-link' : 'image-link') }}
                        </a>
                    @endif
                </div>

                <div class="">
                    <input type="submit" class="btn btn-primary" value="{{ __('campaigns/gallery.actions.save') }}">
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>

<div class="gallery-toggle collapse !visible">
    <div class="modal-body panel-image-edit">
        <div class="">
            <x-box>
                <p class="help-block">{{ __('entities/image.focus.helper') }}</p>
                <div class="focus-selector max-h-screen relative mb-2 overflow-auto">
                    <div class="focus absolute text-white cursor-pointer text-3xl" style="@if(empty($image->focus_x))display: none; @else left: {{ $image->focus_x }}px; top: {{ $image->focus_y }}px; @endif">
                        <i class="fa-regular fa-bullseye fa-2x hover:text-red" aria-hidden="true"></i>
                    </div>
                    <img class="focus-image max-w-none" src="{{ $image->getImagePath(0) }}" alt="img" />
                </div>
                <div class="flex gap-2 sm:gap-5 items-center mb-5 pull-right">
                    {!! Form::model($image, ['route' => ['campaign.gallery.save-focus', $image], 'method' => 'POST', 'class' => '']) !!}
                        <input type="submit" class="btn btn-danger" value="{{ __('campaigns/gallery.actions.reset_focus') }}">
                    {!! Form::close() !!}
                    {!! Form::model($image, ['route' => ['campaign.gallery.save-focus', $image], 'method' => 'POST', 'class' => '']) !!}
                        {!! Form::hidden('focus_x', null) !!}
                        {!! Form::hidden('focus_y', null) !!}
                        <input type="submit" class="btn btn-primary" value="{{ __('entities/image.actions.save_focus') }}">
                    {!! Form::close() !!}

                </div>
            </x-box>
        </div>
    </div>
</div>

@if(!$image->isFolder() || $image->hasNoFolders())
    {!! Form::open(['method' => 'DELETE','route' => ['images.destroy', $image->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
    {!! Form::close() !!}
@endif
