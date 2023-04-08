<?php
/** @var \App\Models\CampaignSubmission[] $submissions */
?>

<div class="box box-submissions">
    <div class="box-body">
        <div class="row">
            @foreach($submissions as $submission)
                <div class="col-md-6 col-lg-4">
                    <div class="box box-solid">
                        <div class="box-body">
                            <h4 class="box-title">{{ $submission->user->name }}</h4>
                            <p class="help-block">{!! nl2br($submission->text) !!}</p>
                        </div>
                        <div class="box-footer">
                            <a class="btn btn-xl btn-primary"
                               href="#"
                               data-toggle="dialog-ajax"
                               data-url="{{ route('campaign_submissions.edit', [$submission->id, 'action' => 'approve']) }}"
                               data-target="submission-dialog"
                               title="{{ __('campaigns/submissions.actions.accept') }}">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span class="sr-only">{{ __('campaigns/submissions.actions.accept') }}</span>
                            </a>

                            <a class="btn btn-xl btn-danger pull-right"
                               href="#"
                               data-toggle="dialog-ajax"
                               data-url="{{ route('campaign_submissions.edit', [$submission->id, 'action' => 'reject']) }}"
                               data-target="submission-dialog"
                               title="{{ __('campaigns/submissions.actions.reject') }}">
                                <i class="fa-solid fa-times" aria-hidden="true"></i>
                                <span class="sr-only">{{ __('campaigns/submissions.actions.reject') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if ($submissions->hasPages())
        <div class="box-footer text-right">
            {!! $submissions->links() !!}
        </div>
    @endif
</div>
