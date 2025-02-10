
<div class="grid grid-cols-2 gap-5">
    @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])

    @include('cruds.fields.calendar', ['isParent' => true, 'dynamicNew' => true])
</div>
