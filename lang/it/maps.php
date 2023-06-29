<?php

return [
    'actions'       => [],
    'create'        => [],
    'edit'          => [],
    'errors'        => [
        'chunking'  => [
            'error'     => 'Si è verificato un errore durante il raggruppamento della mappa. Contatta il team su :discord per ricevere supporto.',
            'running'   => [
                'edit'      => 'La mappa non può essere modificata mentre si sta raggruppando.',
                'explore'   => 'La mappa non può essere visualizzata mentre si sta raggruppando.',
                'time'      => 'Questa operazione può richiedere da alcuni minuti a diverse ore, a seconda delle dimensioni della mappa.',
            ],
        ],
        'dashboard' => [
            'missing'   => 'Questa mappa necessita di un immagine per poterla visualizzare nella Pagina Principale.',
        ],
        'explore'   => [
            'missing'   => 'Per favore, aggiungi un immagine alla mappa prima di poterla esplorare.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Indicatore',
        'center_x'          => 'Posizione Longitudinale Predefinita',
        'center_y'          => 'Posizione Latitudinale Predefinita',
        'centering'         => 'Centratura',
        'distance_measure'  => 'Misura di distanza',
        'distance_name'     => 'Etichetta dell\'unità di distanza',
        'has_clustering'    => 'Raggruppa gli indicatori',
        'initial_zoom'      => 'Zoom iniziale',
        'is_real'           => 'Usa OpenStreetMaps',
        'max_zoom'          => 'Zoom massimo',
        'min_zoom'          => 'Zoom minimo',
        'tabs'              => [
            'coordinates'   => 'Coordinate',
            'marker'        => 'Indicatore',
        ],
    ],
    'helpers'       => [
        'center'                => 'Modificando i seguenti valori si controlla l\'area della mappa su cui si concentra l\'attenzione. Se questi valori vengono lasciati vuoti, verrà focalizzato il centro della mappa.',
        'centering'             => 'La centratura su un marcatore avrà la priorità sulle coordinate predefinite.',
        'chunked_zoom'          => 'Raggruppa automaticamente i marcatori quando sono vicini.',
        'descendants'           => 'Questa lista contiene tutte le mappe che sono discendenti di questa mappa, e non solo quelle direttamente sotto di essa.',
        'distance_measure_2'    => 'Per 100 pixel che misurano 1 chilometro, inserire un valore di 0,0041.',
        'has_clustering'        => 'Raggruppa automaticamente i marcatori quando sono vicini.',
        'initial_zoom'          => 'Il livello di zoom iniziale con cui viene caricata la mappa. Il valore predefinito è :default, mentre il valore massimo consentito è :max e il valore minimo consentito è :min.',
        'is_real'               => 'Selezionare questa opzione se desideri utilizzare una mappa del mondo reale invece dell\'immagine caricata. Questa opzione disabilita i livelli.',
        'max_zoom'              => 'Il massimo ingrandimento possibile per una mappa. Il valore predefinito è :default, mentre il valore massimo consentito è :max.',
        'min_zoom'              => 'Il massimo ingrandimento possibile per una mappa. Il valore predefinito è :default, mentre il valore minimo consentito è :min.',
        'nested_without'        => 'Visualizzazione di tutte le mappe che non hanno una mappa genitore. Fai clic su una riga per visualizzare le mappe figlio.',
    ],
    'index'         => [],
    'maps'          => [],
    'panels'        => [
        'groups'    => 'Gruppi',
        'legend'    => 'Legenda',
    ],
    'placeholders'  => [
        'center_marker' => 'Lascia vuoto per caricare la mappa nel mezzo',
        'center_x'      => 'Lascia vuoto per caricare la mappa nel mezzo',
        'center_y'      => 'Lascia vuoto per caricare la mappa nel mezzo',
        'distance_name' => 'Km, miglia, piedi, hamburgers',
    ],
    'show'          => [],
    'tooltips'      => [
        'chunking'  => [
            'running'   => 'La mappa è in fase di raggruppamento. Questo processo può richiedere da alcuni minuti a ore.',
        ],
    ],
];
