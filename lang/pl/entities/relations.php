<?php

return [
    'actions'           => [
        'mode-map'      => 'Wizualizacja relacji',
        'mode-table'    => 'Tabela relacji i powiązań',
    ],
    'bulk'              => [
        'delete'    => '{1} Usunięto :count relację.|[2,3,4] Usunięto :count relacje.|[5,*] Usunięto :count relacji.',
        'fields'    => [
            'delete_mirrored'   => 'Usuń obustronnie',
            'unmirror'          => 'Rozwiąż obustronność',
            'update_mirrored'   => 'Aktualizuj obustronnie',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Usuwa relacje obu stron',
            'unmirror'          => 'Rozwiązuje obustronność relacji',
            'update_mirrored'   => 'Aktualizuje relacje obu stron.',
        ],
        'success'   => [
            'editing'           => '{1} Zmienono :count relację.|[2,3,4] Zmienono :count relacje.|[5,*] Zmienono :count relacji.',
            'editing_partial'   => '{1} Zmienono :count/:total relację.|[2,3,4] Zmienono :count/:total relacje.|[5,*] Zmienono :count/:total relacji.',
        ],
    ],
    'call-to-action'    => 'Zobacz rozkład rozmaitych relacji, łączących elementy kampanii.',
    'connections'       => [
        'map_point'         => 'Punkt na mapie',
        'mention'           => 'Wzmianka',
        'quest_element'     => 'Część zadania',
        'timeline_element'  => 'Część historii',
    ],
    'create'            => [
        'helper'        => 'Łączy :name z jednym lub kilkoma innymi elementami',
        'new_title'     => 'Nowa relacja',
        'success_bulk'  => '{1} Dodano :count relacji do :entity.|[2,4] Dodano :count relacje do :entity.|[5,*] Dodano :count relacji do :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Te elementy łączy relacja obustronna. Wybór tej opcji usunie obydwie strony relacji.',
        'option'    => 'Usuń relację obustronną.',
    ],
    'destroy'           => [
        'mirrored'  => 'Usunie również drugą stronę relacji. Tej akcji nie można cofnąć.',
        'success'   => 'Usunięto relację :target elementu :entity.',
    ],
    'fields'            => [
        'attitude'  => 'Nastawienie',
        'is_pinned' => 'Przypięta',
        'owner'     => 'Źródło',
        'target'    => 'Obiekt',
        'targets'   => 'Elementy obiektu',
        'two_way'   => 'Stwórz relację obustronną',
        'unmirror'  => 'Zmień w relację jednostronną',
    ],
    'filters'           => [
        'connection'    => 'Rodzaj relacji',
        'name'          => 'Cel relacji',
    ],
    'helper'            => 'Ustalaj relacje między elementami, określając ich rodzaj i widoczność. Relacje można przypinać do opisu elementów.',
    'helpers'           => [
        'description'   => 'Opisuje charakter relacji między dwoma elementami.',
        'no_relations'  => 'Element nie jest obecnie związany z żadnym innym elementem tej kampanii.',
    ],
    'hints'             => [
        'attitude'  => 'Pole opcjonalne, pozwalająca określić kolejność wyświetlania relacji, w porządku malejącym.',
        'two_way'   => 'Jeżeli wybierzesz relację obustronną, taka sama relacja zostanie stworzona dla obiektu. Jeżeli potem zmodyfikujesz relację dla jednej strony, druga nie zostanie zaktualizowana.',
    ],
    'index'             => [
        'title' => 'Relacje',
    ],
    'options'           => [
        'mentions'          => 'Relacje + związki + wzmianki',
        'only_relations'    => 'Tylko relacje bezpośrednie',
        'related'           => 'Relacje + związki',
        'relations'         => 'Relacje',
        'show'              => 'Pokaż',
    ],
    'panels'            => [
        'related'   => 'Związki',
    ],
    'placeholders'      => [
        'attitude'  => '-100 do 100, gdzie 100 to bardzo pozytywny stosunek',
    ],
    'show'              => [
        'title' => 'Relacje elementu :name',
    ],
    'types'             => [
        'family_member'         => 'Członek rodziny',
        'organisation_member'   => 'Członek organizacji',
    ],
    'update'            => [
        'success'   => 'Zaktualizowano relację :target z elementem :entity.',
        'title'     => 'Zaktualizuj relacje dla :name',
    ],
];
