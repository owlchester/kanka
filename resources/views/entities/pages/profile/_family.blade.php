<?php /** @var \App\Models\Family $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ __('families.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->location)
                    <p>
                        <b>{{ __('families.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->family)
                    <p>
                        <b>{{ __('families.fields.family') }}</b><br />
                        {!! $model->family->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
