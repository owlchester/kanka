<?php

return [
    'actions'       => [
        'back'      => 'Torna a :name',
        'edit'      => 'Modifica mappa',
        'explore'   => 'Esplora',
    ],
    'create'        => [
        'title' => 'Nuova Mappa',
    ],
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
        'grid'              => 'Griglia',
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
        'chunked_zoom'          => 'Raggruppa automaticamente gli indicatori quando sono vicini.',
        'descendants'           => 'Questa lista contiene tutte le mappe che sono discendenti di questa mappa, e non solo quelle direttamente sotto di essa.',
        'distance_measure'      => 'Se si assegna alla mappa una misurazione della distanza, si abilita lo strumento di misurazione nella modalità di esplorazione.',
        'distance_measure_2'    => 'Per 100 pixel che misurano 1 chilometro, inserire un valore di 0,0041.',
        'grid'                  => 'Definisce la dimensione della griglia che verrà visualizzata nella modalità di esplorazione.',
        'has_clustering'        => 'Raggruppa automaticamente gli indicatori quando sono vicini.',
        'initial_zoom'          => 'Il livello di zoom iniziale con cui viene caricata la mappa. Il valore predefinito è :default, mentre il valore massimo consentito è :max e il valore minimo consentito è :min.',
        'is_real'               => 'Selezionare questa opzione se desideri utilizzare una mappa del mondo reale invece dell\'immagine caricata. Questa opzione disabilita i livelli.',
        'max_zoom'              => 'Il massimo ingrandimento possibile per una mappa. Il valore predefinito è :default, mentre il valore massimo consentito è :max.',
        'min_zoom'              => 'Il massimo ingrandimento possibile per una mappa. Il valore predefinito è :default, mentre il valore minimo consentito è :min.',
        'missing_image'         => 'Salva la mappa con un\'immagine prima di poter aggiungere livelli e marcatori.',
        'nested_without'        => 'Visualizzazione di tutte le mappe che non hanno una mappa genitore. Fai clic su una riga per visualizzare le mappe figlio.',
    ],
    'index'         => [],
    'maps'          => [],
    'panels'        => [
        'groups'    => 'Gruppi',
        'layers'    => 'Livelli',
        'legend'    => 'Legenda',
        'markers'   => 'Indicatori',
        'settings'  => 'Impostazioni',
    ],
    'placeholders'  => [
        'center_marker' => 'Lascia vuoto per caricare la mappa nel mezzo',
        'center_x'      => 'Lascia vuoto per caricare la mappa nel mezzo',
        'center_y'      => 'Lascia vuoto per caricare la mappa nel mezzo',
        'distance_name' => 'Km, miglia, piedi, hamburgers',
        'grid'          => 'Distanza in pixel tra gli elementi della griglia. Lascia vuoto per nascondere la griglia.',
        'name'          => 'Nome della mappa',
        'type'          => 'Sotterraneo, Città, Galassia',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mappe',
        ],
    ],
    'tooltips'      => [
        'chunking'  => [
            'running'   => 'La mappa è in fase di raggruppamento. Questo processo può richiedere da alcuni minuti a qualche ora.',
        ],
    ],
];
