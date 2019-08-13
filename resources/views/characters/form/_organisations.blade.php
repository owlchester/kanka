<?php
/**
 * @var \App\Models\OrganisationMember $organisation
 * @var \App\Models\Character $model
 * @var \App\Services\FormService $formService
 */
$organisations = isset($model) ? $model->organisations()->with('organisation')->get() : $formService->prefillCharacterOrganisation($source);
?>
<div class="character-organisations">
    @foreach ($organisations as $organisation)
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <select name="organisations[{{ $organisation->id }}]" class="form-control select2" style="width: 100%"
                            data-url="{{ route('organisations.find') }}"
                            data-placeholder="{{ __('crud.placeholders.organisation') }}"
                            data-language="{{ LaravelLocalization::getCurrentLocale() }}"
                    >
                        <option value="{{ $organisation->organisation->id }}">{{ $organisation->organisation->name }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        {!! Form::text('organisation_roles[' . $organisation->id . ']', $organisation->role, [
                            'class' => 'form-control',
                            'placeholder' => __('organisations.members.placeholders.role'),
                        ]) !!}

                        <span class="input-group-btn">
                            <span class="member-delete btn btn-danger" title="{{ __('crud.remove') }}">
                                <i class="fa fa-trash"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<button class="btn btn-default" id="add_organisation" href="#" title="{{ __('characters.actions.add_organisation') }}">
    <i class="fa fa-plus"></i> {{ __('characters.actions.add_organisation') }}
</button>

<div id="template_organisation" style="display: none">
    <div class="row">
        <div class="col-md-6">
            <select name="organisations[]" class="form-control tmp-org" style="width: 100%"
                    data-url="{{ route('organisations.find') }}"
                    data-placeholder="{{ __('crud.placeholders.organisation') }}"
                    data-language="{{ LaravelLocalization::getCurrentLocale() }}"
            >
            </select>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                {!! Form::text('organisation_roles[]', null, [
                    'class' => 'form-control',
                    'placeholder' => __('organisations.members.placeholders.role'),
                ]) !!}

                <span class="input-group-btn">
                    <span class="member-delete btn btn-danger" title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash"></i>
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>

