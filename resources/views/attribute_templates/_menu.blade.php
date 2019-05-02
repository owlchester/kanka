<div class="box box-solid">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->attributeTemplate))
                <li class="list-group-item">
                    <b>{{ trans('attribute_templates.fields.attribute_template') }}</b>

                    <span class="pull-right">
                                <a href="{{ route('attribute_templates.show', $model->attributeTemplate->id) }}" data-toggle="tooltip"
                                   title="{{ $model->attributeTemplate->tooltip() }}">{{ $model->attributeTemplate->name }}</a>
                            </span>
                    <br class="clear" />
                </li>
            @endif

        </ul>
        @include('.cruds._actions')
    </div>
</div>

@if (!isset($exporting) && ($count = $model->descendants()->acl()->count()) > 0)
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('crud.tabs.menu') }}
            </h3>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
                <li class="@if(empty($active))active @endif">
                    <a href="{{ route('attribute_templates.show', $model) }}">
                        {{ __('crud.panels.entry') }}
                    </a>
                </li>
                <li class="@if(!empty($active) && $active == 'attribute_templates')active @endif">
                    <a href="{{ route('attribute_templates.attribute_templates', $model) }}">
                        {{ __('attribute_templates.show.tabs.attribute_templates') }}
                        <span class="label label-default pull-right">
                            {{ $count }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif