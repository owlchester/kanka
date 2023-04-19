<?php
/** @var \App\Models\CampaignSubmission[] $submissions */
?>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-2 xl:gap-5">
    @foreach($submissions as $submission)
        <x-box>
            <h4 class="text-lg">{{ $submission->user->name }}</h4>
            <p class="help-block">{!! nl2br($submission->text) !!}</p>

            <div class="grid grid-cols-2 gap-5">
                <a class="btn btn-primary"
                    href="#"
                    data-toggle="dialog-ajax"
                    data-url="{{ route('campaign_submissions.edit', [$submission->id, 'action' => 'approve']) }}"
                    data-target="submission-dialog"
                    title="{{ __('campaigns/submissions.actions.accept') }}">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('campaigns/submissions.actions.accept') }}</span>
                </a>

                <a class="btn btn-danger "
                    href="#"
                    data-toggle="dialog-ajax"
                    data-url="{{ route('campaign_submissions.edit', [$submission->id, 'action' => 'reject']) }}"
                    data-target="submission-dialog"
                    title="{{ __('campaigns/submissions.actions.reject') }}">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('campaigns/submissions.actions.reject') }}</span>
                </a>
            </div>
        </x-box>
    @endforeach
</div>
@if ($submissions->hasPages())
    <div class="text-right">
        {!! $submissions->links() !!}
    </div>
@endif
