<?php

return [
    'create'        => [
        'success'   => 'Dodano relację :target do elementu :entity.',
        'title'     => 'Nowa relacja elementu :name.',
    ],
    'destroy'       => [
        'success'   => 'Usunięto relację :target elementu :entity.',
    ],
    'fields'        => [
        'attitude'  => 'Nastawienie',
        'is_star'   => 'Przypięta',
        'relation'  => 'Relacja',
        'target'    => 'Obiekt',
        'two_way'   => 'Stwórz relację obustronną',
    ],
    'helper'        => 'Ustalaj relacje między elementami, określając ich rodzaj i widoczność. Relacje można przypinać do opisu elementów.',
    'hints'         => [
        'attitude'  => 'Pole opcjonalne, pozwalająca określić kolejność wyświetlania relacji, w porządku malejącym.',
        'mirrored'  => [
            'text'  => 'To obustronna relacja z :link.',
            'title' => 'Obustronna',
        ],
        'two_way'   => 'Jeżeli wybierzesz relację obustronną, taka sama relacja zostanie stworzona dla obiektu. Jeżeli potem zmodyfikujesz relację dla jednej strony, druga nie zostanie zaktualizowana.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 do 100, gdzie 100 to bardzo pozytywny stosunek',
        'relation'  => 'Rywal, Przyjaciółka od serca, Rodzeństwo',
        'target'    => 'Wybierz element',
    ],
    'show'          => [
        'title' => 'Relacje elementu :name',
    ],
    'teaser'        => 'Doładuj kampanię, by zyskać dostęp do grafu relacji. Kliknij, by dowiedzieć się więcej o doładowanych kampaniach.',
    'types'         => [
        'family_member'         => 'Członek rodziny',
        'organisation_member'   => 'Członek organizacji',
    ],
    'update'        => [
        'success'   => 'Zaktualizowano relację :target elementu :entity.',
        'title'     => 'Zaktualizuj relacje dla :name',
    ],
];
