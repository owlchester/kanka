<div class="tab-pane" id="form-dashboard">
    <x-helper :text="__('campaigns.helpers.dashboard')" />

    <x-grid type="1/1">
        <x-forms.field
            field="excerpt"
            :label="__('campaigns.fields.excerpt')"
            tooltip
            :helper="__('campaigns.helpers.excerpt')"
        >
            <textarea name="excerpt" id="excerpt" class="w-full html-editor">{!! old('excerpt', $campaign->excerptForEdition) !!}</textarea>
        </x-forms.field>

        <x-forms.field field="header" :label="__('campaigns.fields.header_image')" tooltip :helper="__('campaigns.helpers.header_image')">
            <input type="hidden" name="remove-header_image" />
            <div class="grid gap-2 grid-cols-4">
                <div class="col-span-3 flex flex-col gap-2 ">
                    <div class="field field-header-image">
                        <input type="file" name="header_image" class="image w-full" id="header_image" accept=".jpg, .jpeg, .png, .gif, .webp, .gif" />
                    </div>
                    <div class="field field-header-url">
                        <input type="text" name="header_image_url" value="{{ old('header_image_url') }}" maxlength="255" class="w-full" placeholder="{{ __('crud.placeholders.image_url') }}" />
                    </div>

                    <x-helper>
                        {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => Limit::readable()->upload()]) }}
                        {{ __('crud.hints.image_recommendation', ['width' => '1200', 'height' => '400']) }}
                        @include('cruds.fields.helpers.share', ['max' => 25])
                    </x-helper>
                </div>
                @if (!empty($campaign->header_image))
                    <div class="basis-1/4 preview">
                        @include('cruds.fields._image_preview', [
                            'image' => $campaign->thumbnail(200, 160, 'header_image'),
                            'title' => $campaign->name,
                            'target' => 'remove-header_image'
                        ])
                    </div>
                @endif
            </div>
        </x-forms.field>
    </x-grid>
</div>

@if(!request()->ajax())
@include('editors.editor')
@endif
