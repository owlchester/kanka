<?php

return [
    'actions'       => [
        'apply_template'    => 'Applica un Template per gli Attributi',
        'manage'            => 'Gestisci',
        'remove_all'        => 'Cancella tutti',
    ],
    'fields'        => [
        'attribute'             => 'Attributo',
        'community_templates'   => 'Templates della Community',
        'is_private'            => 'Attributi Privati',
        'is_star'               => 'Fissato',
        'template'              => 'Template',
        'value'                 => 'Valore',
    ],
    'helpers'       => [
        'delete_all'    => 'Sei sicuro di voler cancellare tutti gli attributi di questa entità?',
    ],
    'hints'         => [
        'is_private'    => 'Puoi nascondere tutti gli attributi di un\'entità per tutti i membri al di fuori del gruppo degli amministratori rendendoli privati.',
    ],
    'index'         => [
        'success'   => 'Attributo aggiornato per :entity.',
        'title'     => 'Attributi per :name',
    ],
    'placeholders'  => [
        'attribute' => 'Numero di conquiste, Grado di Sfida, Iniziativa, Popolazione',
        'block'     => 'Nome del blocco',
        'checkbox'  => 'Nome del checkbox',
        'section'   => 'Nome della sezione',
        'template'  => 'Seleziona un template',
        'value'     => 'Valore dell\'attributo',
    ],
    'template'      => [
        'success'   => 'Il Template di Attributi :name è stato applicato su :entity',
        'title'     => 'Applica un Template degli Attributi per :name',
    ],
    'types'         => [
        'attribute' => 'Attributo',
        'block'     => 'Blocco',
        'checkbox'  => 'Checkbox',
        'section'   => 'Sezione',
        'text'      => 'Testo multilinea',
    ],
    'visibility'    => [
        'entry'     => 'Gli Attributi sono mostrati nella tab Principale.',
        'private'   => 'Attributo visibile solamente ai membri del ruolo "Admin".',
        'public'    => 'Attributo visibile a tutti i membri.',
        'tab'       => 'Gli attributi sono visualizzati solamente nella tab degli Attributi.',
    ],
];
