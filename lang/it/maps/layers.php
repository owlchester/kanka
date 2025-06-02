<?php

return [
    'actions'       => [
        'add'   => 'Aggiungi un nuovo livello',
    ],
    'base'          => 'Livello Base',
    'bulks'         => [
        'delete'    => '{1} Rimosso :count livello.|[2,*] Rimossi :count livelli.',
        'patch'     => '{1} Modificato :count livello.|[2,*] Modificati :count livelli.',
    ],
    'create'        => [
        'success'   => 'Livello :name creato.',
        'title'     => 'Nuovo Livello',
    ],
    'delete'        => [
        'success'   => 'Livello :name eliminato.',
    ],
    'edit'          => [
        'success'   => 'Livello :name modificato.',
        'title'     => 'Modifica Livello :name',
    ],
    'fields'        => [
        'position'  => 'Posizione',
        'type'      => 'Tipo di Livello',
    ],
    'helper'        => [
        'amount_v2' => 'Carica i livelli su una mappa per cambiare l\'immagine di sfondo visualizzata sotto gli indicatori o come sovrapposizione sopra la mappa ma sotto gli indicatori.',
        'is_real'   => 'I livelli non sono disponibili mentre usi OpenStreetMaps.',
    ],
    'index'         => [
        'title' => 'Livelli di :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'name'          => 'Sotterranei, Livello 2, Relitto',
        'position'      => 'Primo',
        'position_list' => 'Dopo :name',
    ],
    'reorder'       => [
        'save'      => 'Salva il nuovo ordine',
        'success'   => '{1} Riordinato :count livello.|[2,*] Riordinati :count livelli.',
        'title'     => 'Riordina livelli',
    ],
    'short_types'   => [
        'overlay'       => 'Sovrapposizione',
        'overlay_shown' => 'Sovrapposizione (mostra automaticamente)',
        'standard'      => 'Predefinita',
    ],
    'types'         => [
        'overlay'       => 'Sovrapposizione (visualizzata sopra il livello attivo)',
        'overlay_shown' => 'Sovrapposizione visibile per impostazione predefinita',
        'standard'      => 'Livello predefinito (per passare da un livello all\'altro)',
    ],
];
