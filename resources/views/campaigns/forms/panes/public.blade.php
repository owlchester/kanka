<div class="tab-pane" id="form-public">
    {!! Form::hidden('is_public', 0) !!}
    <label>{!! Form::checkbox('is_public') !!}
        {{ __('campaigns.visibilities.public') }}
    </label>
    <p class="help-block">{{ __('campaigns.helpers.visibility') }}<br />
        <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fas fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
    </p>
</div>