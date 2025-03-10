<?php

return [
    'actions'       => [
        'copy'  => 'Kopírovať',
        'move'  => 'Presunúť',
    ],
    'errors'        => [
        'permission'        => 'V tejto kampani nemáš povolenie na vytváranie objektov tohto typu.',
        'permission_update' => 'Na presun tohto objektu nemáš oprávnenie.',
        'same_campaign'     => 'Pre presun musíš zvoliť inú kampaň, kam tento objekt chceš presunúť.',
        'unknown_campaign'  => 'Neznáma kampaň.',
    ],
    'fields'        => [
        'campaign'      => 'Cieľová kampaň',
        'copy'          => 'Vytvoriť kópiu',
        'select_one'    => 'Vyber kampaň',
    ],
    'helpers'       => [
        'copy'  => 'Vytvoriť kópiu objektu v cieľovej kampani.',
    ],
    'panel'         => [
        'description'           => 'Vyber kampaň, do ktorej chceš tento objekt presunúť alebo skopírovať.',
        'description_bulk_copy' => 'Vyber kampaň, do ktorej chceš vybrané objekty skopírovať.',
        'title'                 => 'Presun alebo kópia objektu do inej kampane',
    ],
    'success'       => 'Objekt :name presunutý.',
    'success_copy'  => 'Objekt :name skopírovaný.',
    'title'         => 'Presun :name',
    'warnings'      => [
        'custom'    => 'Tento objekt nepatrí štandardnému modulu, ale vlastnému typu objektu :module. V cieľovej kampani bude vytvorený vo forme Poznámky.',
    ],
];
