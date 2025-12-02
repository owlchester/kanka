<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */

$options = [
    '' => __('entities/relations.options.relations'),
    'only_relations' => __('entities/relations.options.only_relations'),
    'related' => __('entities/relations.options.related'),
    'mentions' => __('entities/relations.options.mentions'),
];

?>
@if(!$campaign->boosted())
    <x-premium-cta :campaign="$campaign">
        <p>{{ __('entities/relations.call-to-action') }}</p>
    </x-premium-cta>
    <?php return ?>
@endif

<x-form :action="['entities.relations.index', $campaign, $entity]" method="GET">
    <div class="join w-full">
        <x-forms.select name="option" :options="$options" :selected="$option" class="w-full join-item" />
        <input type="submit" value="{{ __('entities/relations.options.show') }}" class="btn2 btn-primary btn-sm join-item" />
    </div>
    <input type="hidden" name="mode" value="map" />
</x-form>

<x-box class="box-entity-relations box-entity-relations-explorer">
    <div class="text-center text-xg" id="spinner">
        <x-icon class="load" />
    </div>
    <div id="cy" class="cy @isset($isPost) cy-post min-h-80 text-base-content bg-box @else min-h-screen bg-box text-base-content cy-map @endif hidden" data-url="{{ route('entities.relations_map', [$campaign, $entity, 'option' => $option]) }}"></div>
</x-box>

@section('scripts')
    @parent
    @vite('resources/js/relations.js')
@endsection

@section('styles')
    @parent
    @vite('resources/css/relations.css')
@endsection
