<?php
/** @var \App\Models\CampaignSubmission[] $submissions */
?>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-2 xl:gap-5">
    @foreach($submissions as $submission)
        <x-box>
            <h4 class="text-lg">{{ $submission->user->name }}</h4>
            <p class="help-block">{!! nl2br($submission->text) !!}</p>

            <div class="grid grid-cols-2 gap-5">
                <a class="btn2 btn-error "
                    href="#"
                    data-toggle="dialog-ajax"
                    data-url="{{ route('campaign_submissions.edit', [$campaign, $submission->id, 'action' => 'reject']) }}"
                    data-target="submission-dialog"
                    title="{{ __('campaigns/submissions.actions.reject') }}">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('campaigns/submissions.actions.reject') }}</span>
                </a>

                <a class="btn2 btn-primary"
                   href="#"
                   data-toggle="dialog-ajax"
                   data-url="{{ route('campaign_submissions.edit', [$campaign, $submission->id, 'action' => 'approve']) }}"
                   data-target="submission-dialog"
                   title="{{ __('campaigns/submissions.actions.accept') }}">
                    <x-icon class="check" />
                    <span class="sr-only">{{ __('campaigns/submissions.actions.accept') }}</span>
                </a>
            </div>
        </x-box>
    @endforeach
</div>
{!! $submissions->onEachSide(0)->links() !!}
