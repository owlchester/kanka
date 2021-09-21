<?php

return [
    'actions'       => [
        'copy'  => 'Kopírovat',
        'move'  => 'Přesunout',
    ],
    'errors'        => [
        'permission'        => 'V tomto tažení nemáš dostatečná oprávnění pro tvorbu tohoto typu objektů.',
        'permission_update' => 'Nemáš oprávnění přesunout tento objekt.',
        'same_campaign'     => 'Musíš vybrat jiné tažení, kam přesunout tento objekt.',
        'unknown_campaign'  => 'Neznámé tažení',
    ],
    'fields'        => [
        'campaign'      => 'Cálové tažení',
        'copy'          => 'Zkopírovat',
        'select_one'    => 'Vybrat tažení',
    ],
    'panel'         => [
        'description'           => 'Vyber tažení, kam chceš přesunout objekt nebo vytvořit jeho kopii.',
        'description_bulk_copy' => 'Vyber tažení, kde chceš vytvořit kopii objektů.',
        'title'                 => 'Přesunout nebo zkopírovat objekt do jiného tažení',
    ],
    'success'       => 'Objekt :name přesunut.',
    'success_copy'  => 'Objekt :name zkopírován.',
    'title'         => 'Přesunout objekt :name',
];
