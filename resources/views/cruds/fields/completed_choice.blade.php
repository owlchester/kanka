
<div class="completed">
    <label for="status">{{ trans('quests.fields.status') }}</label>
    <select name="status" class="w-full">
        <option value=""></option>
        <option value="0">{{ trans('quests.status.not_started') }}</option>
        <option value="1">{{ trans('quests.status.ongoing') }}</option>
        <option value="2">{{ trans('quests.status.completed') }}</option>
        <option value="3">{{ trans('quests.status.abandoned') }}</option>
    </select>
</div>
