<x-grid type="1/1">

    <x-helper>{!! __('campaigns/sidebar.helpers.image') !!}</x-helper>

    @include('cruds.fields.image-old', ['model' => $campaign, 'campaignImage' => true, 'imageLabel' => 'campaigns.fields.image', 'recommended' => '240x208'])
</x-grid>
