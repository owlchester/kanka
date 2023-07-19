<?php

return [
    'actions'           => [
        'add'   => 'Aggiungi un link',
    ],
    'call-to-action'    => 'Aggiungendo collegamenti a risorse esterne a questa entità, come ad esempio a DnDBeyond, questi verranno visualizzati direttamente nella panoramica dell\'entità.',
    'create'            => [
        'success'   => 'Link :name aggiunto a :entity.',
        'title'     => 'Aggiunto un link a :name',
    ],
    'destroy'           => [
        'success'   => 'Link :name rimosso.',
    ],
    'fields'            => [
        'icon'      => 'Icona',
        'name'      => 'Nome',
        'position'  => 'Posizione',
        'url'       => 'URL',
    ],
    'go'                => [
        'actions'       => [
            'confirm'   => 'Sono sicuro',
            'trust'     => 'Non chiedermelo di nuovo',
        ],
        'description'   => 'Questo link esterno ti porterà a :link. Sei sicuro di volerci andare?',
        'title'         => 'Stai lasciando Kanka',
    ],
    'helpers'           => [
        'icon'      => 'Puoi personalizzare l\'icona visualizzata per il collegamento. Puoi utilizzare una delle icone di :fontawesome, :rpgawesome o lasciare questo campo vuoto per il valore predefinito. Per saperne di più, consulta i nostri :docs.',
        'parent'    => 'Visualizza questo collegamento rapido dopo un elemento della barra laterale, anziché nella sezione dei collegamenti rapidi della barra laterale.',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Le campagne premium possono aggiungere link a siti esterni.',
        'title'     => 'Links per :name',
    ],
    'update'            => [
        'success'   => 'Link :name aggiornato per :entity',
        'title'     => 'Modifica link per :name',
    ],
];
