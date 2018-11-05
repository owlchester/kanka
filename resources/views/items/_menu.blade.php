<div class="box">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if ($model->type)
                <li class="list-group-item">
                    <b>{{ trans('items.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.lists.location')
            @if ($campaign->enabled('characters') && !empty($model->character))
                <li class="list-group-item">
                    <b>{{ trans('items.fields.character') }}</b>
                    <span  class="pull-right">
                            <a href="{{ route('characters.show', $model->character->id) }}" data-toggle="tooltip" title="{{ $model->character->tooltip() }}">{{ $model->character->name }}</a>
                            </span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions')
    </div>
</div>


@if (!isset($exporting))
    <div class="box box-solid">
        <div class="box-header with-border visible-xs">
            <h3 class="box-title">
                {{ __('crud.tabs.menu') }}
            </h3>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
                <li class="@if(empty($active))active @endif">
                    <a href="{{ route('items.show', $model) }}">
                        {{ __('crud.panels.entry') }}
                    </a>
                </li>
                @if ($campaign->enabled('quests') && $model->quests()->acl()->count() > 0)
                    <li class="@if(!empty($active) && $active == 'quests')active @endif">
                        <a href="{{ route('items.quests', $model) }}" title="{{ __('items.show.tabs.quests') }}">
                            {{ __('items.show.tabs.quests') }}
                            <span class="label label-default pull-right">
                                <?=$model->quests()->acl()->count()?>
                            </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif