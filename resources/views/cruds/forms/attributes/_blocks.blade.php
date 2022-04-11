<?php
$nameBlock = 'col-xs-12 col-sm-4';
$textBlock = 'col-xs-7 col-sm-4 col-md-5 col-lg-6';
$actionBlock = 'col-xs-5 col-sm-4 col-md-3 col-lg-2';

?>
<!-- Attribute Section -->
@section('modals')
    @parent
<div class="attribute-templates">
    <div class="form-group hidden" id="attribute_template">
        <div class="row attribute_row">
            <div class="{{ $nameBlock }}">
                <div class="input-group">
                    <span class="input-group-addon hidden-xs hidden-sm">
                        <span class="fa fa-arrows-alt-v"></span>
                    </span>
                    {!! Form::text('attr_name[$TMP_ID$]', null, [
                        'placeholder' => __('entities/attributes.placeholders.attribute'),
                        'class' => 'form-control',
                        'maxlength' => 191
                    ]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::text('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'form-control kanka-mentions', 'maxlength' => 191, 'data-remote' => route('search.live')]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
                <i class="far fa-star fa-2x margin-r-5"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                @endif

                <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            </div>
            {!! Form::hidden('attr_type[$TMP_ID$]', '') !!}
        </div>
    </div>
    <!-- Block Section -->
    <div class="form-group hidden" id="block_template">
        <div class="row attribute_row">
            <div class="{{ $nameBlock }}">
                <div class="input-group">
                <span class="input-group-addon hidden-xs hidden-sm">
                    <span class="fa fa-arrows-alt-v"></span>
                    </span>
                    {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.block'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                <div class="hidden">
                    {!! Form::text('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
                <i class="far fa-star fa-2x margin-r-5"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"></i>

    @if($isAdmin)
                {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
    @endif
                <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            </div>
            {!! Form::hidden('attr_type[$TMP_ID$]', 'block') !!}
        </div>
    </div>
    <!-- Text Section -->
    <div class="form-group hidden" id="text_template">
        <div class="row attribute_row">
            <div class="{{ $nameBlock }}">
                <div class="input-group">
                    <span class="input-group-addon hidden-xs hidden-sm">
                        <span class="fa fa-arrows-alt-v"></span>
                    </span>
                    {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.block'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::textarea('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'form-control kanka-mentions', 'rows' => 3, 'data-remote' => route('search.live')]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
                <i class="far fa-star fa-2x margin-r-5"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"></i>

    @if ($isAdmin)
                {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
    @endif
                <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            </div>

            {!! Form::hidden('attr_type[$TMP_ID$]', 'text') !!}
        </div>
    </div>
    <!-- Number Section -->
    <div class="form-group hidden" id="number_template">
        <div class="row attribute_row">
            <div class="{{ $nameBlock }}">
                <div class="input-group">
                    <span class="input-group-addon hidden-xs hidden-sm">
                        <span class="fa fa-arrows-alt-v"></span>
                    </span>
                    {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.number'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::number('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'form-control']) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
                <i class="far fa-star fa-2x margin-r-5"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"></i>

    @if ($isAdmin)
                {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
    @endif
                <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            </div>

            {!! Form::hidden('attr_type[$TMP_ID$]', 'number') !!}
        </div>
    </div>
    <div class="form-group hidden" id="checkbox_template">
        <div class="row attribute_row">
            <div class="{{ $nameBlock }}">
                <div class="input-group">
                    <span class="input-group-addon hidden-xs hidden-sm">
                        <span class="fa fa-arrows-alt-v"></span>
                    </span>
                    {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.checkbox'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::checkbox('attr_value[$TMP_ID$]', 1, false) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
                <i class="far fa-star fa-2x margin-r-5"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"></i>

    @if ($isAdmin)
                {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
    @endif

                <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            </div>

            {!! Form::hidden('attr_type[$TMP_ID$]', 'checkbox') !!}
        </div>
    </div>
    <!-- Section -->
    <div class="form-group hidden" id="section_template">
        <div class="row attribute_row">
            <div class="{{ $nameBlock }}">
                <div class="input-group">
                    <span class="input-group-addon hidden-xs hidden-sm">
                        <span class="fa fa-arrows-alt-v"></span>
                    </span>
                    {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.section'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::hidden('attr_value[$TMP_ID$]', null) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
                <i class="far fa-star fa-2x margin-r-5"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"></i>

    @if ($isAdmin)
                {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
    @endif
                <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            </div>
            {!! Form::hidden('attr_type[$TMP_ID$]', 'section') !!}
        </div>
    </div>
    <!-- Random -->
    <div class="form-group hidden" id="random_template">
        <div class="row attribute_row">
            <div class="{{ $nameBlock }}">
                <div class="input-group">
                    <span class="input-group-addon hidden-xs hidden-sm">
                        <span class="fa fa-arrows-alt-v"></span>
                    </span>
                    {!! Form::text('attr_name[$TMP_ID$]', null, [
                        'placeholder' => __('entities/attributes.placeholders.random.name'),
                        'class' => 'form-control',
                        'maxlength' => 191
                    ]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::text('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.random.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
                <i class="far fa-star fa-2x margin-r-5"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                @endif
                <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            </div>
            {!! Form::hidden('attr_type[$TMP_ID$]', \App\Models\Attribute::TYPE_RANDOM) !!}
        </div>
    </div>
</div>
@endsection
