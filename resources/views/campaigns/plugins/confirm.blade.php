<?php /**
 * @var \App\Models\Plugin $plugin
 * @var \App\Models\CampaignPlugin $version
 */
?>

{!! Form::open(['url' => route('campaign_plugins.import', $plugin), 'method' => 'POST']) !!}

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">
        {!! __('campaigns/plugins.import.title', ['plugin' => $plugin->name]) !!}
    </h4>
</div>
<div class="modal-body">
@include('partials.errors')

    <p>{{ __('campaigns/plugins.import.helper', [
    'count' => $version->version->entities()->count(),
    'plugin' => $plugin->name
    ]) }}</p>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="force_private" />
            {{ __('campaigns/plugins.import.option_private') }}
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="only_new" />
            {{ __('campaigns/plugins.import.option_only_import') }}
        </label>
    </div>
</div>
<div class="modal-footer">
  <input type="submit" value="{{ __('campaigns/plugins.import.button') }}" class="btn btn-primary" />
</div>


{!! Form::close() !!}
