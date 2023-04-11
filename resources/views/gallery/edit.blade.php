<?php /** @var \App\Models\Image $image */
$imageCount = 0;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('campaigns/gallery.actions.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">{!! $image->name !!}</h4>
</div>
<div class="modal-body panel-image-edit">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="">
        @if($image->is_folder)
            <div class="text-center my-5">
                <i class="fa-solid fa-folder fa-4x" aria-hidden="true"></i>
            </div>
        @else
            <div class="text-center">
                <img src="{{ Img::crop(300, 300)->url($image->path) }}" class="max-w-full rounded" alt="{{ $image->name }}" />
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
                @if(!$image->is_folder)
                    <div class="label label-default text-xs" title="{{ __('campaigns/gallery.fields.ext') }}">
                        <i class="fa-regular fa-image" aria-hidden="true"></i>
                        {{ strtoupper($image->ext) }}
                    </div>
                    <div class="label label-default text-xs" title="{{ __('campaigns/gallery.fields.size') }}">
                        <i class="fa-regular fa-weight-hanging" aria-hidden="true"></i>
                        {{ $image->niceSize() }}
                    </div>
                @endif
                <div class="label label-default text-xs" title="{{ __('campaigns/gallery.fields.created_by') }}">
                    <i class="fa-regular fa-user" aria-hidden="true"></i>
                    {{ $image->user ? $image->user->name : __('crud.users.unknown') }}
                </div>
            </div>

            {!! Form::model($image, ['route' => ['images.update', $image], 'method' => 'PUT', 'class' => '']) !!}

            <div class="form-group">
                <label for="name" class="control-label required">{{ __('crud.fields.name') }}</label>
                {!! Form::text('name', null, ['maxlength' => 45, 'class' => 'form-control']) !!}
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-5">
            @if(!$image->is_folder)
            <div class="form-group">
                <label for="folder_id" class="control-label">{{ __('campaigns/gallery.fields.folder') }}</label>
                {!! Form::select('folder_id', $folders, null, ['class' => 'form-control']) !!}
            </div>

            @endif

            @include('cruds.fields.visibility_id', ['model' => $image])
            </div>

            <div class="flex gap-2 sm:gap-5 items-center mb-5">
                <div class="grow flex gap-2 sm:gap-5">
                @if(!$image->is_folder || $image->hasNoFolders())
                    <a role="button" tabindex="0" class="btn-dynamic-delete text-red-500 hover:text-red-800" data-toggle="popover"
                       title="{{ __('crud.remove') }}"
                       data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-confirm-form'>{{ __('crud.remove') }}</a>">
                        <i class="fa-regular fa-trash" aria-hidden="true"></i>
                        {{ __('crud.remove') }}
                    </a>
                @endif
                    @if(!$image->is_folder)
                        <a href="{{ $image->getUrl() }}" target="_blank">
                            <i class="fa-regular fa-link" aria-hidden="true"></i> {{ __('campaigns/gallery.actions.full') }}
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


@if(!$image->is_folder || $image->hasNoFolders())
    {!! Form::open(['method' => 'DELETE','route' => ['images.destroy', $image->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
    {!! Form::close() !!}
@endif
