<?php
    $selectedOption = [];
?>
<div class="form-group">
    <label>{{ __('organisations.fields.members') }}</label>

    <select multiple="multiple" name="members[]" id="members" class="form-control form-members" style="width: 100%" data-url="{{ route('characters.find', ['with_family' => '1']) }}">
        @foreach ($selectedOption as $key => $val)
            <option value="{{ $key }}" selected="selected">{{ $val }}</option>
        @endforeach
    </select>
</div>