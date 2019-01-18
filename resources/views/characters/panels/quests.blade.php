<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('characters.show.tabs.quests') }}
        </h2>

        <?php  $r = $model->questGiver()->acl()->orderBy('name', 'ASC')->with(['characters', 'locations', 'quests'])->paginate(); ?>
        @if ($r->count() > 0)
            <p class="help-block">{{ __('characters.quests.helpers.quest_giver') }}</p>
            @include('characters.panels._quest')
        @endif

        <?php  $r = $model->quests()->acl()->orderBy('name', 'ASC')->with(['characters', 'locations', 'quests'])->paginate(); ?>
        @if ($r->count() > 0)
            <p class="help-block">{{ __('characters.quests.helpers.quest_member') }}</p>
            @include('characters.panels._quest')
        @endif
    </div>
</div>