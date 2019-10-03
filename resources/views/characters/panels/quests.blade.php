<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header ">
            {{ trans('characters.show.tabs.quests') }}
        </h2>

        <?php  $r = $model->questGiver()->orderBy('name', 'ASC')->with(['characters', 'locations', 'quests'])->paginate(); ?>
        @if ($r->count() > 0)
            <p class="help-block">{{ __('characters.quests.helpers.quest_giver') }}</p>
            @include('characters.panels._quest', ['role' => false])
        @endif

        <?php  $r = $model->relatedQuests()->paginate(); ?>
        @if ($r->count() > 0)
            <p class="help-block">{{ __('characters.quests.helpers.quest_member') }}</p>
            @include('characters.panels._quest', ['role' => true])
        @endif
    </div>
</div>