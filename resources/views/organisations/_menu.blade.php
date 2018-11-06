<div class="box">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @include('cruds.lists.location')
            @if (!empty($model->type))
                <li class="list-group-item">
                    <b>{{ trans('organisations.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif

            @if (!empty($model->organisation))
                <li class="list-group-item">
                    <b>{{ trans('crud.fields.organisation') }}</b>
                    <span class="pull-right">
                        <a href="{{ $model->organisation->getLink() }}" data-toggle="tooltip" title="{{ $model->organisation->tooltip() }}">{{ $model->organisation->name }}</a>
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
                    <a href="{{ route('organisations.show', $model) }}">
                        {{ __('crud.panels.entry') }}
                    </a>
                </li>
                <li class="@if(!empty($active) && $active == 'organisations')active @endif">
                    <a href="{{ route('organisations.organisations', $model) }}" title="{{ __('organisations.show.tabs.organisations') }}">
                        {{ __('organisations.show.tabs.organisations') }}
                        <span class="label label-default pull-right">
                                <?=$model->descendants()->acl()->count()?>
                            </span>
                    </a>
                </li>
                @if ($campaign->enabled('characters'))
                    <li class="@if(!empty($active) && $active == 'members')active @endif">
                        <a href="{{ route('organisations.members', $model) }}" title="{{ __('organisations.show.tabs.members') }}">
                            {{ __('organisations.show.tabs.members') }}
                            <span class="label label-default pull-right">
                                <?=$model->members()->acl()->has('character')->count()?>
                            </span>
                        </a>
                    </li>
                    <li class="@if(!empty($active) && $active == 'all_members')active @endif">
                        <a href="{{ route('organisations.all-members', $model) }}" title="{{ __('organisations.show.tabs.all_members') }}">
                            {{ __('organisations.show.tabs.all_members') }}
                            <span class="label label-default pull-right">
                                <?=$model->allMembers()->acl()->has('character')->count()?>
                            </span>
                        </a>
                    </li>
                @endif

                @if ($campaign->enabled('quests') && $model->quests()->acl()->count() > 0)
                    <li class="@if(!empty($active) && $active == 'quests')active @endif">
                        <a href="{{ route('organisations.quests', $model) }}" title="{{ __('organisations.show.tabs.quests') }}">
                            {{ __('organisations.show.tabs.quests') }}
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