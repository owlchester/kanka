<?php /** @var \App\Models\Campaign $model */?>
<div class="tab-pane" id="form-public">
    <x-grid type="1/1">

        <x-grid type="1/1">
            @include('campaigns.forms._visibility', ['campaign' => $model ?? null])

            @if (isset($model) && $model->isPublic())
                <x-helper>
                    <p>{!! __('campaigns.helpers.view_public', ['link' => '<a href="' . route('dashboard', $campaign) . '" class="text-link">' . route('dashboard', $campaign) . '</a>']) !!}</p>
                </x-helper>

                @if ($model->publicHasNoVisibility())
                    <x-alert type="warning">
                        {!! __('campaigns.helpers.public_no_visibility', [
        'fix' => '<a href="' . route('campaigns.campaign_roles.public', $campaign) . '" class="text-link">' . __('crud.fix-this-issue') . '</a>',
        ]) !!}
                    </x-alert>
                @endif
            @endif
            <hr />

            @include('campaigns.forms.panes._discovery')

        </x-grid>
    </x-grid>
</div>
