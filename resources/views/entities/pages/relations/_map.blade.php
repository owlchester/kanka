<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */

$options = [
    '' => __('entities/relations.options.relations'),
    'only_relations' => __('entities/relations.options.only_relations'),
    'related' => __('entities/relations.options.related'),
    'mentions' => __('entities/relations.options.mentions'),
];

$pageUrl = isset($isPost) ? '' : route('entities.relations.index', [$campaign, $entity, 'mode' => 'map', 'option' => $option]);

?>
@if(!$campaign->boosted())
    <x-premium-cta :campaign="$campaign">
        <p>{{ __('entities/relations.call-to-action') }}</p>
    </x-premium-cta>
    <?php return ?>
@endif

<div id="relations-map">
    <relations-map
        url="{{ route('entities.relations_map', [$campaign, $entity, 'option' => $option]) }}"
        page-url="{{ $pageUrl }}"
        empty-label="{{ __('entities/relations.empty') }}"
        :option="@js($option ?? '')"
        :labels="@js($options)"
        :embedded="@js($isPost ?? false)"
    ></relations-map>
</div>

@section('scripts')
    @parent
    @vite('resources/js/relations.js')
@endsection

@section('styles')
    @parent
    @vite('resources/css/relations.css')
@endsection
