<?php

return [
    'actions'       => [
        'add'   => 'Dodaj novi sloj',
    ],
    'base'          => 'Temeljni sloj',
    'create'        => [
        'success'   => 'Kreiran sloj :name.',
        'title'     => 'Novi sloj',
    ],
    'delete'        => [
        'success'   => 'Obrisan sloj :name.',
    ],
    'edit'          => [
        'success'   => 'Ažuriran sloj :name.',
        'title'     => 'Uredi sloj :name',
    ],
    'fields'        => [
        'position'  => 'Pozicija',
        'type'      => 'Vrsta sloja',
    ],
    'helper'        => [
        'amount'            => 'Na kartu možeš dodati do :amount slojeva da bi promijenili pozadinsku sliku prikazanu ispod svojih markera.',
        'boosted_campaign'  => ':boosted mogu imati do :amount slojeva.',
    ],
    'placeholders'  => [
        'name'      => 'Podzemlje, Razina 2, Olupina broda',
        'position'  => 'Neobavezno polje za postavljanje redoslijeda u kojem se slojevi pojavljuju.',
    ],
    'short_types'   => [
        'overlay'       => 'Prekrivanje',
        'overlay_shown' => 'Prekrivanje (automatsko prikazivanje)',
        'standard'      => 'Standardno',
    ],
    'types'         => [
        'overlay'       => 'Prekrivanje (prikazano iznad aktivnog sloja)',
        'overlay_shown' => 'Prekrivanje prikazano kao zadano',
        'standard'      => 'Standardni sloj (prebacivanje između slojeva)',
    ],
];
