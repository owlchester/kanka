<div class="tab-pane" id="form-dashboard">
    <x-grid type="1/1">
        <x-helper :text="__('campaigns.helpers.dashboard')" />

        <x-forms.field
            field="excerpt"
            :label="__('campaigns.fields.excerpt')"
            :helper="__('campaigns.helpers.excerpt')"
            >
            <textarea name="excerpt" id="excerpt" class="w-full html-editor">{!! old('excerpt', $model->excerptForEdition ?? null) !!}</textarea>
        </x-forms.field>

        <x-forms.field
            field="header"
            :label="__('campaigns.fields.header_image')">
            <p class="text-neutral-content m-0 md:hidden">{{ __('campaigns.helpers.header_image') }}</p>
            <input type="hidden" name="remove-header_image" />
            <div class="flex gap-2 ">
                <div class="basis-3/4 flex flex-col gap-2">
                    <x-forms.field
                        field="header-image">
                        <input type="file" name="header_image" class="image w-full" id="header_image" accept=".jpg, .jpeg, .png, .gif, .webp, .gif" />
                    </x-forms.field>
                    <x-forms.field
                        field="image-url">
                        <input type="text" name="header_image_url" value="{{ old('header_image_url') }}" maxlength="255" class="w-full" placeholder="{{ __('crud.placeholders.image_url') }}" />
                    </x-forms.field>

                    <p class="text-neutral-content m-0">
                        {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => Limit::readable()->upload()]) }}
                        {{ __('crud.hints.image_recommendation', ['width' => '1200', 'height' => '400']) }}
                        @include('cruds.fields.helpers.share', ['max' => 25])
                    </p>
                </div>
                <div class="basis-1/4 preview">
                    @if (!empty($model->header_image))
                        @include('cruds.fields._image_preview', [
                            'image' => $model->thumbnail(200, 160, 'header_image'),
                            'title' => $model->name,
                            'target' => 'remove-header_image'
                        ])
                    @endif
                </div>
            </div>
        </x-forms.field>
    </x-grid>
</div>
