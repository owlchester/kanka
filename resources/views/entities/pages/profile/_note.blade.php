<?php /** @var \App\Models\Note $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ __('notes.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->note)
                    <p class="entity-note" data-foreign="{{ $model->note_id }}">
                        <b>{{ __('notes.fields.note') }}</b><br />
                        {!! $model->note->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
