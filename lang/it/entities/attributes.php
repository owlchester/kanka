<?php

return [
    'actions'       => [
        'apply_template'    => 'Applica un Modello per gli Attributi',
        'load'              => 'Carica',
        'manage'            => 'Gestisci',
        'more'              => 'Altro',
        'remove_all'        => 'Elimina tutto',
        'save_and_edit'     => 'Applica e Modifica',
        'save_and_story'    => 'Applica e Visualizza',
        'show_hidden'       => 'Mostra attributi nascosti',
        'toggle_privacy'    => 'Privato/Pubblico',
    ],
    'errors'        => [
        'loop'                  => 'Il calcolo di questo attributo è un ciclo infinito!',
        'no_attribute_selected' => 'Seleziona prima uno o più attributi.',
        'too_many_v2'           => 'Campi massimi raggiunti (:count/:max). Elimina alcuni attributi prima di poterne aggiungere altri.',
    ],
    'fields'        => [
        'attribute'             => 'Attributo',
        'community_templates'   => 'Modelli della Comunità',
        'is_private'            => 'Attributi Privati',
        'is_star'               => 'Fissato',
        'preferences'           => 'Preferenze',
        'template'              => 'Modello',
        'value'                 => 'Valore',
    ],
    'filters'       => [
        'name'  => 'Nome dell\'attributo',
        'value' => 'Valore dell\'attributo',
    ],
    'helpers'       => [
        'delete_all'    => 'Sei sicuro di voler cancellare tutti gli attributi di questa entità?',
        'is_private'    => 'Consenti solo ai membri del ruolo :admin-role di vedere gli attributi di questa entità.',
        'setup'         => 'Puoi rappresentare elementi come Punti Ferita o l\'Intelligenza di un\'entità con degli attributi. È possibile aggiungere manualmente gli attributi facendo clic sul pulsante :manage, oppure applicare automaticamente quelli di un modello di attributo.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Attributi per :entity aggiornati.',
        'title'     => 'Attributi per :name',
    ],
    'labels'        => [
        'checkbox'  => 'Nome del Checkbox',
        'name'      => 'Nome dell\'attributo',
        'section'   => 'Nome della sezione',
        'value'     => 'Valore dell\'attributo',
    ],
    'live'          => [
        'success'   => 'Attributo :attribute aggiornato.',
        'title'     => 'Aggiornando :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Numero di Conquiste, Grado di Sfida, Iniziativa, Popolazione',
        'block'     => 'Blocca nome',
        'checkbox'  => 'Nome del Checkbox',
        'icon'      => [
            'class' => 'Classe: fas fa-users di FontAwesome o RPG Awesome',
            'name'  => 'Nome dell\'icona',
        ],
        'number'    => 'Valore numerico',
        'random'    => [
            'name'  => 'Nome dell\'attributo',
            'value' => '1-100 o lista di valori separati da una virgola',
        ],
        'section'   => 'Nome della sezione',
        'template'  => 'Seleziona un modello',
        'value'     => 'Valore dell\'attributo',
    ],
    'ranges'        => [
        'text'  => 'Opzioni disponibili :options',
    ],
    'sections'      => [
        'unorganised'   => 'Disorganizzato',
    ],
    'show'          => [
        'hidden'    => 'Attributi Nascosti',
        'title'     => 'Attributi di :name',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Modello caricato',
            'title'     => 'Carica dal Modello',
        ],
        'success'   => 'Il Modello di Attributi :name è stato applicato a :entity',
        'title'     => 'Applica un Modello degli Attributi per :name',
    ],
    'title'         => 'Attributi',
    'toasts'        => [
        'bulk_deleted'  => 'Attributi eliminati',
        'bulk_privacy'  => 'Privacy degli attributi attivata',
        'lock'          => 'Attributo bloccato',
        'pin'           => 'Attributo fissato',
        'unlock'        => 'Attributo sbloccato',
        'unpin'         => 'Attributo non fissato',
    ],
    'types'         => [
        'attribute' => 'Attributo',
        'block'     => 'Blocca',
        'checkbox'  => 'Checkbox',
        'icon'      => 'Icona',
        'number'    => 'Numero',
        'random'    => 'Casuale',
        'section'   => 'Sezione',
        'text'      => 'Testo Multilinea',
    ],
    'update'        => [
        'success'   => 'Attributi per :entity aggiornati',
    ],
    'visibility'    => [
        'entry'     => 'Gli attributi sono visualizzati nel menu dell\'entità.',
        'private'   => 'Attributo visibile solo ai membri del ruolo "Amministratore".',
        'public'    => 'Attributo visibile a tutti i membri.',
        'tab'       => 'L\'attributo viene visualizzato solo nella scheda Attributi.',
    ],
];
