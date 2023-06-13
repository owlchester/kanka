@include('partials.errors')
@inject('campaignService', 'App\Services\CampaignService')


{!! Form::open([
    'route' => ['campaign_dashboard_widgets.store'],
    'method'=>'POST',
    'data-shortcut' => '1',
]) !!}

<article>
    @include('dashboard.widgets.forms._' . $widget)

    <x-dialog.footer>
        <button type="submit" class="btn2 btn-primary">
            {{ __('crud.save') }}
        </button>
    </x-dialog.footer>
</article>

<input type="hidden" name="widget" value="{{ $widget }}">
@if(empty($dashboards) && !empty($dashboard))
    <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
@endif
{!! Form::close() !!}
