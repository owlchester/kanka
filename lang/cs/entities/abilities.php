<?php

return [
    'actions'   => [
        'add'                       => 'Přidat schopnosti',
        'import_from_race'          => 'Přidat schopnosti rasy',
        'import_from_race_mobile'   => 'Schopnosti ras',
        'reset'                     => 'Vynulovat použití schopností',
    ],
    'create'    => [
        'success'           => 'Schopnost :ability přidána objektu :entity.',
        'success_multiple'  => 'Schopnosti :abilities přidány objektu :entity.',
        'title'             => 'Přidat schopnosti ke :name',
    ],
    'fields'    => [
        'note'      => 'Poznámka',
        'position'  => 'Pozice',
    ],
    'helpers'   => [
        'note'  => 'Na objekty je možné odkazovat pomocí pokročilých odkazů (např. :code) a atributů objektu (např. :attr) v tomto poli.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Postava nemá žádnou rasu.',
            'not_character' => 'Tento objekt není postava.',
        ],
        'success'   => '{1} :count importovaná schopnost.|[2,4] :count importované schopnosti.|[5,*] :count importovaných schopností.',
    ],
    'show'      => [
        'helper'    => 'P5idat schopnosti objektu. U schopnosti je možné upravit viditelnost nebo ji odstranit. Schopnosti, příslušející stejné nadřazené schopnosti lze použít jako filtry.',
        'title'     => 'Schopnosti objektu pro :name',
    ],
    'update'    => [
        'title' => 'Schopnost objektu pro :name',
    ],
];
