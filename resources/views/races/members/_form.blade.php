<div class="form-group">
    <label>{{ __('races.fields.members') }}</label>
    <select multiple="multiple" name="members[]" id="members" class="form-control form-members" style="width: 100%" data-url="{{ route('characters.find', ['with_race' => '1']) }}"></select>
</div>
