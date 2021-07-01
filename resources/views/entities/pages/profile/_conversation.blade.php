<?php /** @var \App\Models\Conversation $model */
?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">

                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ __('conversations.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->target)
                    <p class="entity-target">
                        <b>{{ __('conversations.fields.target') }}</b><br />
                        {{ __('conversations.targets.' . $model->target) }}
                    </p>
                @endif

            </div>
        </div>
    </div>
</div>
