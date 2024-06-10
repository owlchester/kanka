<?php
?><x-forms.field
    field="position"
    :label="__($trans . '.fields.position')"
    :helper="__($trans . '.helpers.position')">

    <input type="number" name="position" class="w-full" value="{{ FormCopy::field('position')->string() ?: old('position', $model->position ?? null) }}" maxlength="1" />
</x-forms.field>
