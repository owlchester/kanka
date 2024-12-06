<?php

return [
    'actions'       => [
        'entry'             => 'Scrivi una voce personalizzata per questo indicatore.',
        'remove'            => 'Rimuovi indicatore',
        'reset-polygon'     => 'Ripristina posizioni',
        'save_and_explore'  => 'Salva e Esplora',
        'start-drawing'     => 'Inizia a disegnare',
        'update'            => 'Modifica Indicatori',
    ],
    'bulks'         => [
        'delete'    => '{1} Rimosso :count indicatore.|[2,*] Rimossi :count indicatori.',
        'patch'     => '{1} Aggiornato :count indicatore.|[2,*] Aggiornati :count indicatori.',
    ],
    'circle_sizes'  => [
        'custom'    => 'Personalizzata',
        'huge'      => 'Enorme',
        'large'     => 'Grande',
        'small'     => 'Piccola',
        'standard'  => 'Predefinito',
        'tiny'      => 'Minuscola',
    ],
    'create'        => [
        'success'   => 'Indicatore :name creato.',
        'title'     => 'Nuovo Indicatore',
    ],
    'delete'        => [
        'success'   => 'Indicatore :name rimosso.',
    ],
    'edit'          => [
        'success'   => 'Indicatore :name aggiornato.',
        'title'     => 'Modifica Indicatore :name',
    ],
    'fields'        => [
        'bg_colour'     => 'Colore di sfondo',
        'circle_radius' => 'Raggio del cerchio',
        'copy_elements' => 'Copia elementi',
        'custom_icon'   => 'Icona personalizzata',
        'custom_shape'  => 'Forma Personalizzata a Poligono',
        'font_colour'   => 'Colore dell\'icona',
        'group'         => 'Gruppo di indicatori',
        'icon'          => 'Icona',
        'is_draggable'  => 'Trascinabile',
        'latitude'      => 'Latitudine',
        'longitude'     => 'Longitudine',
        'opacity'       => 'Opacità',
        'pin_size'      => 'Dimensioni dell\'Indicatore',
        'polygon_style' => [
            'stroke'            => 'Colore del tratto',
            'stroke-opacity'    => 'Opacità del tratto',
            'stroke-width'      => 'Larghezza del tratto',
        ],
        'popupless'     => 'Popup del Tooltip',
        'size'          => 'Dimensioni',
    ],
    'helpers'       => [
        'base'                      => 'Aggiungi indicatori alla mappa cliccando su un qualsiasi punto della stessa.',
        'copy_elements'             => 'Copia gruppi, livelli e indicatori.',
        'copy_elements_to_campaign' => 'Copia gruppi, livelli e indicatori delle mappe. Gli indicatori collegati a un\'entità saranno convertiti in un indicatore standard.',
        'custom_icon_v2'            => 'Usa le icone da :fontawesome, :rpgawesome, o da un\'icona SVG personalizzata. Scopri di più in :docs.',
        'custom_radius'             => 'Seleziona l\'opzione dimensione personalizzata dal menu a tendina per definire una dimensione.',
        'draggable'                 => 'Attivalo per permettere lo spostamento di un indicatore in modalità Esplora.',
        'is_popupless'              => 'Disabilita la visualizzazione del tooltip dell\'indicatore al passaggio del mouse.',
        'label'                     => 'Un\'etichetta viene visualizzata come un blocco di testo sulla mappa. Il contenuto sarà il nome dell\'indicatore o dell\'entità.',
        'polygon'                   => [
            'edit'  => 'Modifica il poligono trascinando i suoi bordi e i suoi nodi.',
        ],
    ],
    'hints'         => [
        'entry' => 'Modifica l\'icona per scrivere una voce personalizzata.',
    ],
    'icons'         => [
        'custom'        => 'Icona personalizzata',
        'entity'        => 'Immagine dell\'entità',
        'exclamation'   => 'Icona con Punto di Esclamazione',
        'marker'        => 'Icona dell\'Indicatore',
        'question'      => 'Icona con Punto Interrogativo',
    ],
    'index'         => [
        'title' => 'Indicatore di :name',
    ],
    'pitches'       => [
        'poly'  => 'Disegna forme poligonali personalizzate per rappresentare bordi e altre forme irregolari.',
    ],
    'placeholders'  => [
        'custom_icon'   => 'Prova :example1 o :example2',
        'custom_shape'  => '100, 100 200, 240 340, 110',
        'name'          => 'Richiesto se non è stata selezionata alcuna entità',
    ],
    'presets'       => [
        'helper'    => 'Fai clic su una preimpostazione per caricarla o crearne una nuova.',
    ],
    'shapes'        => [
        '0' => 'Cerchio',
        '1' => 'Quadrato',
        '2' => 'Triangolo',
        '3' => 'Personalizzato',
    ],
    'sizes'         => [
        '0' => 'Minuscolo',
        '1' => 'Normale',
        '2' => 'Piccolo',
        '3' => 'Grande',
        '4' => 'Enorme',
    ],
    'tabs'          => [
        'circle'    => 'Cerchio',
        'label'     => 'Etichetta',
        'marker'    => 'Indicatore',
        'polygon'   => 'Poligono',
        'preset'    => 'Preimpostazione',
    ],
];
