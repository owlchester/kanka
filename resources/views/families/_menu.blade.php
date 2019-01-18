<div class="box">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->family))
                <li class="list-group-item">
                    <b>{{ trans('families.fields.family') }}</b>
                    <span class="pull-right">
                        <a href="{{ $model->family->getLink() }}" data-toggle="tooltip" title="{{ $model->family->tooltip() }}">{{ $model->family->name }}</a>
                    </span>
                    <br class="clear" />
                </li>
            @endif

            @include('cruds.lists.location')
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
                    <a href="{{ route('families.show', $model) }}">
                        {{ __('crud.panels.entry') }}
                    </a>
                </li>
                <li class="@if(!empty($active) && $active == 'families')active @endif">
                    <a href="{{ route('families.families', $model) }}" title="{{ __('families.show.tabs.families') }}">
                        {{ __('families.show.tabs.families') }}
                        <span class="label label-default pull-right">
                                <?=$model->descendants()->acl()->count()?>
                            </span>
                    </a>
                </li>
                @if ($campaign->enabled('characters'))
                    <li class="@if(!empty($active) && $active == 'members')active @endif">
                        <a href="{{ route('families.members', $model) }}" title="{{ __('families.show.tabs.members') }}">
                            {{ __('families.show.tabs.members') }}
                            <span class="label label-default pull-right">
                                <?=$model->members()->acl()->count()?>
                            </span>
                        </a>
                    </li>
                    <li class="@if(!empty($active) && $active == 'all_members')active @endif">
                        <a href="{{ route('families.all-members', $model) }}" title="{{ __('families.show.tabs.all_members') }}">
                            {{ __('families.show.tabs.all_members') }}
                            <span class="label label-default pull-right">
                                <?=$model->allMembers()->acl()->count()?>
                            </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif