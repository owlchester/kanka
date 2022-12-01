
<div class="btn-group mr-2">
    <button type="button" class="btn btn-default add_attribute" data-template="#attribute_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
        <i class="fa-solid fa-plus"></i> {{ __('entities/attributes.types.attribute') }}
    </button>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        {{ __('entities/attributes.actions.more') }}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="#" class="add_attribute" data-template="#checkbox_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa-solid fa-check"></i> {{ __('entities/attributes.types.checkbox') }}
            </a>
        </li>
        <li>
            <a href="#" class="add_attribute" data-template="#text_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa-solid fa-align-justify"></i> {{ __('entities/attributes.types.text') }}
            </a>
        </li>
        <li>
            <a href="#" class="add_attribute" data-template="#number_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa-solid fa-hashtag"></i> {{ __('entities/attributes.types.number') }}
            </a>
        </li>
        <li>
            <a  href="#" class="add_attribute" data-template="#section_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa-solid fa-layer-group"></i> {{ __('entities/attributes.types.section') }}
            </a>
        </li>
        @if(request()->is('*/attribute_templates/*') || (isset($entity) && $entity->isAttributeTemplate()))
        <li>
            <a  href="#" class="add_attribute" data-template="#random_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa-solid fa-question"></i> {{ __('entities/attributes.types.random') }}
            </a>
        </li>
        @endif
    </ul>
</div>
@if (isset($entity) && $entity->attributes()->where('is_hidden', '1')->get()->has('0'))
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#hidden-attributes">
        <i class="fa-solid fa-eye-slash" aria-hidden="true"></i>
        {{ __('entities/attributes.actions.show_hidden') }}
    </button>
@endif 
<div class="alert alert-warning alert-too-many-fields margin-top" style="display:none">
    {!! __('entities/attributes.errors.too_many', [
    'max' => number_format(ini_get('max_input_vars'))
]) !!}
</div>

<a href="//docs.kanka.io/en/latest/features/attributes.html" target="_blank">
    {{ __('helpers.attributes.link') }} <i class="fa-solid fa-question-circle"></i>
</a>
<a href="#" class="btn btn-danger pull-right" data-toggle="modal" data-target="#attributes-delete-all-confirm">
    <i class="fa-solid fa-trash"></i> <span class="hidden-xs">{{ __('entities/attributes.actions.remove_all') }}</span>
</a>

<!-- Modal -->
<div class="modal fade" id="attributes-delete-all-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('crud.delete_modal.title') }}</h4>
            </div>
            <div class="modal-body">
                <p>
                    {!! __('entities/attributes.helpers.delete_all') !!}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                <input type="hidden" name="delete-all-attributes" value="" />
                <button type="button" class="btn btn-danger" id="attributes-delete-all-confirm-submit"><span class="fa-solid fa-trash"></span> {{ __('crud.delete_modal.delete') }}</button>
            </div>
        </div>
    </div>
</div>

@if (auth()->user()->isAdmin())
    @php
        $role = \App\Facades\CampaignCache::adminRole();
    @endphp
    <hr />
    <div class="form-group">
        {!! Form::hidden('is_attributes_private', 0) !!}
        <label>{!! Form::checkbox('is_attributes_private', 1, empty($model) ? false : $model->entity->is_attributes_private) !!}
            {{ __('entities/attributes.fields.is_private') }}
        </label>
        <p class="help-block">{!! __('entities/attributes.hints.is_private2', [
    'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), null, ['target' => '_blank'])
    ]) !!}</p>
    </div>
@endif

@section('modals')
    @parent
    @if (isset($entity) && $entity->attributes()->where('is_hidden', '1')->get()->has('0'))
    <div class="modal fade" id="hidden-attributes" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-2xl text-center">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title md-5" id="clickModalLabel">{{ __('entities/attributes.show.hidden') }}</h4>
                        <p class="mt-5">
                            @foreach ($entity->attributes()->ordered()->get() as $attribute)
                                @if ($attribute->is_hidden)
                                    @include('cruds.forms.attributes._hidden_attribute')
                                @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection