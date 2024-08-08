<?php
/** @var \App\Models\CampaignSubmission[] $submissions */
?>

<div class="grid grid-cols-2 xl:grid-cols-4 gap-2 xl:gap-5">
    @foreach($submissions as $submission)
        <x-box>
            <h4 class="text-lg">{{ $submission->user->name }}</h4>
            <x-helper>{!! nl2br($submission->text) !!}</x-helper>

            <div class="grid grid-cols-2 gap-5">
                <a class="btn2 btn-error "
                    href="#"
                    data-toggle="dialog-ajax"
                    data-url="{{ route('campaign_submissions.edit', [$campaign, $submission->id, 'action' => 'reject']) }}"
                    data-target="submission-dialog"
                    title="{{ __('campaigns/submissions.actions.reject') }}">
                    <x-icon class="fa-solid fa-times" />
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
