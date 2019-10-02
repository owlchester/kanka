@php
$themes = [null => ''];
foreach (\App\Models\Theme::all() as $theme):
    $themes[$theme->id] = $theme->__toString();
endforeach;
@endphp

<div class="tab-pane" id="form-boosted">
    <p class="help-block">{{ __('campaigns.helpers.boosted') }}</p>

    <div class="form-group">
        <label>{{ __('campaigns.fields.theme') }}</label>
        {!! Form::select(
            'theme_id',
            $themes,
            null,
            [
                'class' => 'form-control'
            ]
        ) !!}
        <p class="help-block">{{ __('campaigns.helpers.theme') }}</p>
    </div>

    <div class="form-group">
        <label>{{ __('campaigns.fields.css') }}</label>
        {!! Form::textarea('css', null, ['class' => 'form-control', 'id' => 'css']) !!}
        <p class="help-block">{{ __('campaigns.helpers.css') }}</p>
    </div>
</div>