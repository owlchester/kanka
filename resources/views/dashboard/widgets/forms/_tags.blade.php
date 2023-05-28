<div class="form-group">
    <x-forms.tags
        :model="$model ?? null"
        allowClear="true"
    ></x-forms.tags>
    <p class="help-block visible-xs visible-sm">
        {{ __('dashboard.widgets.recent.tags') }}
    </p>
    <input type="hidden" name="save_tags" value="1" />
</div>
