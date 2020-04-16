<?php

return [
    'create'        => [
        'description'   => 'Crea una nuova famiglia',
        'success'       => 'Famiglia \':name\' creata.',
        'title'         => 'Nuova Famiglia',
    ],
    'destroy'       => [
        'success'   => 'Famiglia \':name\' rimossa.',
    ],
    'edit'          => [
        'success'   => 'Famiglia \':name\' aggiornata.',
        'title'     => 'Modifica Famiglia :name',
    ],
    'families'      => [
        'title' => 'Famiglie della Famiglia :name',
    ],
    'fields'        => [
        'families'  => 'Sotto-Famiglie',
        'family'    => 'Famiglia Genitore',
        'image'     => 'Immagine',
        'location'  => 'Luogo',
        'members'   => 'Membri',
        'name'      => 'Nome',
        'relation'  => 'Relazione',
        'type'      => 'Tipologia',
    ],
    'helpers'       => [
        'descendants'   => 'Questa lista contiene tutte le famiglie che sono discendenti di questa famiglia e non solamente quelle direttamente sotto di essa.',
        'nested'        => 'Quando ci si trova nella vista annidata puoi vedere le tue Famiglie in maniera annidata. Famiglie senza genitori saranno mostrate in maniera predefinita. Famiglie con discendenti potranno essere premute per vederne i figli. Potrai continuare ad espandere le famiglie fino a quando non ci saranno più figli da mostrare.',
    ],
    'hints'         => [
        'members'   => 'I membri di una famiglia sono mostrati qui. Un personaggio può essere aggiunto alla famiglia modificando il personaggio, usando il selettore "Famiglia".',
    ],
    'index'         => [
        'add'           => 'Nuova Famiglia',
        'description'   => 'Gestisci le famiglie di :name',
        'header'        => 'Famiglie di :name',
        'title'         => 'Famiglie',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'La lista seguente contiene tutti i personaggi che appartengono alla famiglia ed a tutte le famiglie discendenti.',
            'direct_members'    => 'La maggior parte delle famiglie hanno membri che le gestiscono o che le hanno fatte diventare famose. Di seguito i personaggi che sono membri di questa famiglia.',
        ],
        'title'     => 'Mebri della Famiglia :name',
    ],
    'placeholders'  => [
        'location'  => 'Scegli un luogo',
        'name'      => 'Nome della famiglia',
        'type'      => 'Famiglia Reale, Nobile, Estinta',
    ],
    'show'          => [
        'description'   => 'Una vista dettagliata della famiglia',
        'tabs'          => [
            'all_members'   => 'Tutti i Membri',
            'families'      => 'Famiglie',
            'members'       => 'Membri',
            'relation'      => 'Relazioni',
        ],
        'title'         => 'Famiglia :name',
    ],
];
