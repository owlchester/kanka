<div class="tab-pane" id="form-dashboard">

    <x-grid type="1/1">
        <p class="help-block">{{ __('campaigns.helpers.dashboard') }}</p>

        <x-forms.field
            field="excerpt"
            :label="__('campaigns.fields.excerpt')"
            :helper="__('campaigns.helpers.excerpt')"
            :tooltip="true">
            {!! Form::textarea('excerptForEdition', null, ['class' => 'form-control html-editor', 'id' => 'excerpt', 'name' => 'excerpt']) !!}
        </x-forms.field>

        <x-forms.field
            field="header"
            :label="__('campaigns.fields.header_image')">
            <p class="help-block md:hidden">{{ __('campaigns.helpers.header_image') }}</p>
            {!! Form::hidden('remove-header_image') !!}
            {!! Form::hidden('remove-header_image') !!}
            <div class="grid gap-2 grid-cols-4">
                <div class="col-span-3 flex flex-col gap-2">
                    <div class="field-header-image">
                        {!! Form::file('header_image', ['class' => 'image form-control', 'id' => 'header_image']) !!}
                    </div>
                    <div class="field-image-url">
                        {!! Form::text('header_image_url', null, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
                    </div>

                    <p class="help-block">
                        {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => Limit::readable()->upload()]) }}
                        {{ __('crud.hints.image_recommendation', ['width' => '1200', 'height' => '400']) }}
                        @include('cruds.fields.helpers.share', ['max' => 25])
                    </p>
                </div>
                <div class="">
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
