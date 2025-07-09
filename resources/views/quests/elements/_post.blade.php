@php
    $datagridSorter = new \App\Datagrids\Sorters\QuestElementSorter();
        $elements = $entity->child
                ->elements()
                ->simpleSort($datagridSorter)
                ->paginate();
        $elements->withPath(route('quests.quest_elements.index', [$campaign, $entity->child]));
        $model = $entity->child;
@endphp
@include('quests.elements._elements', ['elements' => $elements])
