<?php /** @var \App\Models\Note $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ __('notes.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
