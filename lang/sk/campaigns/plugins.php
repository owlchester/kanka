<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Deaktivovať pluginy',
            'enable'    => 'Aktivovať pluginy',
            'update'    => 'Aktualizovať pluginy',
        ],
        'changelog'         => 'História zmien',
        'disable'           => 'Deaktivovať plugin',
        'enable'            => 'Aktivovať plugin',
        'import'            => 'Importovať',
        'update'            => 'Aktualizovať plugin',
        'update_available'  => 'Dostupná aktualizácia!',
    ],
    'bulks'         => [
        'delete'    => '{1} Odstránený :count plugin.|[2,4] Odstránené :count pluginy.|[5,*] Odstránených :count pluginov.',
        'disable'   => '{1} Deaktivovaný :count plugin.|[2,4] Deaktivované :count pluginy.|[5,*] Deaktivovaných :count pluginov.',
        'enable'    => '{1} Aktivovaný :count plugin.|[2,4] Aktivované :count pluginy.|[5,*] Aktivovaných :count pluginov.',
        'update'    => '{1} Aktualizovaný :count plugin.|[2,4] Aktualizované :count pluginy.|[5,*] Aktualizovaných :count pluginov.',
    ],
    'destroy'       => [
        'success'   => 'Plugin :plugin odstránený.',
    ],
    'disabled'      => [
        'success'   => 'Plugin :plugin deaktivovaný.',
    ],
    'empty_list'    => 'Táto kampaň nemá aktuálne žiadne pluginy. Zájdi na Trhovisko, ak chceš nejaké nainštalovať a následne sa vráť sem, ich aktivovať.',
    'enabled'       => [
        'success'   => 'Plugin :plugin aktivovaný.',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Neplatný plugin.',
    ],
    'fields'        => [
        'name'      => 'Názov pluginu',
        'obsolete'  => 'Tento plugin bol tímom Kanky označený ako zastaralý, t.z. že nefunguje, ako bolo pôvodne plánované.',
        'status'    => 'Stav',
        'type'      => 'Typ pluginu',
    ],
    'import'        => [
        'button'                => 'Importovať',
        'created'               => 'Nasledujúce objekty boli vytvorené:',
        'helper'                => 'Práve sa chystáš importovať :count objektov z pluginu :plugin. Ak už tento plugin bol importovaný, prepíšu sa zmeny, ktorá boli spravené v daných objektoch.',
        'no_new_entities'       => 'Žiadne nové objekty nebudú importované.',
        'option_only_import'    => 'Importovať len nové objekty a preskočiť už predtým importované.',
        'option_private'        => 'Importovať všetky nové objekty ako súkromné.',
        'success'               => '{1} Importovaný :count objekt z pluginu :plugin.|[2,4] Importované :count objekty z pluginu :plugin.|[5,*] Importovaných :count objektov z pluginu :plugin.',
        'title'                 => 'Importovať :plugin',
        'updated'               => 'Nasledujúce objekty boli aktualizované:',
    ],
    'info'          => [
        'helper'    => 'Ak je vydaná novšia verzia pluginu, môžeš si ho aktualizovať v tvojej kampani na poslednú verziu.',
        'title'     => 'Aktualizácie pluginu :plugin',
        'updates'   => 'Aktualizácie',
    ],
    'pitch'         => 'Inštaluj a spravuj pluginy z :marketplace.',
    'status'        => [
        'always'    => 'Tento plugin bude stále aktívny, dokiaľ ho neodstrániš.',
        'disabled'  => 'Deaktivovaný',
        'enabled'   => 'Aktivovaný',
    ],
    'templates'     => [
        'name'  => ':name od :user',
    ],
    'title'         => 'Pluginy kampane :name',
    'types'         => [
        'attribute' => 'Šablóna atribútov',
        'pack'      => 'Balík s obsahom',
        'theme'     => 'Téma',
    ],
    'update'        => [
        'success'   => 'Plugin :plugin aktualizovaný.',
    ],
];
