<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])

    @include('cruds.fields.event', ['isParent' => true])
    @include('cruds.fields.location')

    <x-forms.field field="date" :label="__('events.fields.date')" :helper="__('events.helpers.date')">
        <input type="text" name="date" value="{{ old('date', $source->date ?? $model->date ?? null) }}" class="w-full" maxlength="191" placeholder="{{  __('events.placeholders.date') }}" />
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
@include('cruds.forms._calendar', ['source' => $source])
