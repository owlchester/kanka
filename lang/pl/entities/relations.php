<?php

return [
    'actions'           => [
        'mode-map'      => 'Mapa relacji',
        'mode-table'    => 'Tabela relacji i elementów powiązanych',
    ],
    'bulk'              => [
        'delete'    => '{1} Usunięto :count relację.|[2,3,4] Usunięto :count relacje.|[5,*] Usunięto :count relacji.',
        'fields'    => [
            'delete_mirrored'   => 'Usuń wzajemnie',
            'unmirror'          => 'Rozwiąż wzajemność',
            'update_mirrored'   => 'Zmień wzajemnie',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Usuwa również wzajemne relacje.',
            'unmirror'          => 'Rozwiązuje obustronność relacji',
            'update_mirrored'   => 'Zmienia relacje wzajemne.',
        ],
        'success'   => [
            'editing'           => '{1} Zmienono :count relację.|[2,3,4] Zmienono :count relacje.|[5,*] Zmienono :count relacji.',
            'editing_partial'   => '{1} Zmienono :count/:total relację.|[2,3,4] Zmienono :count/:total relacje.|[5,*] Zmienono :count/:total relacji.',
        ],
    ],
    'call-to-action'    => 'Zobacz, jak różne elemeny kampanii łączą się ze sobą, wyświetlając relacje, wzmianki i wspólną historię na dynamicznej i interaktywnej mapie.',
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
        'helper'    => 'Te elementy łączy relacja wzajemna. Wybór tej opcji usunie również relację drugiej strony.',
        'option'    => 'Usuń relację obustronną.',
    ],
    'destroy'           => [
        'mirrored'  => 'Usunie również relację drugiej strony. Tej akcji nie można cofnąć.',
        'success'   => 'Usunięto relację :target elementu :entity.',
    ],
    'fields'            => [
        'attitude'          => 'Nastawienie',
        'is_pinned'         => 'Przypięta',
        'link'              => 'Relacja wzajemna',
        'mirror_relation'   => 'Charakter wzajemności',
        'owner'             => 'Źródło',
        'role'              => 'Charakter',
        'target'            => 'Obiekt',
        'targets'           => 'Powiąż z...',
        'two_way'           => 'Wzajemna',
        'unmirror'          => 'Zmień w jednostronną',
    ],
    'filters'           => [
        'connection'    => 'Rodzaj relacji',
        'name'          => 'Obiekt relacji',
    ],
    'helper'            => 'Tworzy relacje między elementami, określa ich rodzaj i widoczność. Relacje można przypinać do opisu elementów.',
    'helpers'           => [
        'description'       => 'Opisuje charakter relacji między dwoma elementami.',
        'link'              => 'Tworzy relację identyczną dla obu stron.',
        'mirror_relation'   => 'Jak cel postrzega ten element (pozostaw puste by skopiować powyższe).',
        'no_relations'      => 'Element nie jest obecnie związany z żadnym innym elementem tej kampanii.',
    ],
    'hints'             => [
        'attitude'  => 'Pole opcjonalne, pozwalająca określić kolejność wyświetlania relacji, w porządku malejącym.',
        'two_way'   => 'Tworzy relację wzajemną. Modyfikacja drugiej strony nie zmieni relacji pierwotnej.',
    ],
    'index'             => [
        'title' => 'Relacje',
    ],
    'linked'            => [
        'break'             => 'Zerwij wzajemność',
        'helper'            => 'To relacja wzajemna z :link',
        'label'             => 'Relacja wzajemna',
        'unmirror-helper'   => 'Zmiana na relację jednostronną niczego nie usunie.',
    ],
    'options'           => [
        'mentions'          => 'Główne + dalsze + wzmianki',
        'only_relations'    => 'Tylko relacje własne',
        'related'           => 'Główne + dalsze',
        'relations'         => 'Główne',
        'show'              => 'Pokaż',
    ],
    'panels'            => [
        'related'   => 'Dalsze',
    ],
    'placeholders'      => [
        'attitude'  => '-100 do 100, gdzie 100 to bardzo pozytywny stosunek',
        'role'      => 'Rywal, przyjaciel, rodzeństwo',
    ],
    'show'              => [
        'title' => 'Relacje :name',
    ],
    'types'             => [
        'family_member'         => 'Członek rodziny',
        'organisation_member'   => 'Członek organizacji',
    ],
    'update'            => [
        'success'   => 'Zmieniono relację :target z elementem :entity.',
        'title'     => 'Zmiana relacji między :source i :target',
    ],
];
