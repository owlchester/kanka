<p>
    <strong>
        <i class="icon fa-solid fa-rocket mr-2"></i> {{ __('crud.delete_modal.callout') }}
    </strong><br />

    {!! __('crud.delete_modal.recoverable', [
'boosted-campaign' => link_to_route('front.pricing', __('concept.boosted-campaign'), '#boost', ['target' => 'blank']),
'day' => config('entities.hard_delete')
])!!}
</p>
