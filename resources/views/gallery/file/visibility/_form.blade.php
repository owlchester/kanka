
    <x-grid type="1/1">
        <p class="text-neutral-content">
            {{ __('entities/image.visibility.helper') }}
        </p>

        @include('cruds.fields.visibility', ['model' => $image])
    </x-grid>
