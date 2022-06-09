<div class="modal-body text-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>

    @if ($campaign->superboosted())
        <p>{{ __('entities/files.call-to-action.error', ['max' => $max]) }}</p>
    @elseif (!$campaign->boosted())
        @include('layouts.callouts.boost-modal', ['texts' => [__('entities/files.call-to-action.error')], 'superboost' => true, 'cta' => __('entities/files.call-to-action.superboost')])
    @else
        @include('layouts.callouts.boost-modal', ['texts' => [__('entities/files.call-to-action.error')], 'cta' => __('entities/files.call-to-action.boost')])
    @endif
</div>

