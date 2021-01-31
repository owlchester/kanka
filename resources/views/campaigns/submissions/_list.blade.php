<?php
/** @var \App\Models\CampaignSubmission[] $submissions */
?>

<div class="row">
    @foreach($submissions as $submission)
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-body">
                    <h4 class="box-title">{{ $submission->user->name }}</h4>
                    <p class="help-block">{!! nl2br($submission->text) !!}</p>
                </div>
                <div class="box-footer">
                    <a class="btn btn-xl btn-primary"
                       href="#"
                       data-toggle="ajax-modal"
                       data-url="{{ route('campaign_submissions.edit', [$submission->id, 'action' => 'approve']) }}"
                       data-target="#entity-modal"
                       title="{{ __('campaigns/submissions.actions.accept') }}">
                        <i class="fa fa-check"></i>
                    </a>

                    <a class="btn btn-xl btn-danger pull-right"
                       href="#"
                       data-toggle="ajax-modal"
                       data-url="{{ route('campaign_submissions.edit', [$submission->id, 'action' => 'reject']) }}"
                       data-target="#entity-modal"
                       title="{{ __('campaigns/submissions.actions.reject') }}">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

{!! $submissions->links() !!}
