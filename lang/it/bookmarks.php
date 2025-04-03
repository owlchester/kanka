<?php

return [
    'actions'           => [
        'customise' => 'Personalizza la barra laterale',
    ],
    'create'            => [
        'title' => 'Nuovo Collegamento Rapido',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Collegamento Rapido :name',
    ],
    'fields'            => [
        'active'            => 'Attivo',
        'dashboard'         => 'Pagina Principale',
        'default_dashboard' => 'Pagina Principale predefinita',
        'filters'           => 'Filtri',
        'menu'              => 'Sottopagina',
        'position'          => 'Posizione',
        'random_type'       => 'Tipo di Entità Casuale',
        'selector'          => 'Configurazione del Collegamento Rapido',
        'target'            => 'Elemento',
    ],
    'helpers'           => [
        'active'            => 'Collegamenti rapidi inattivi non appaiono nella barra laterale',
        'dashboard'         => 'Indirizza il collegamento rapido a una delle Pagine Principale personalizzate della campagna.',
        'default_dashboard' => 'Collegati invece alla Pagina Principale predefinita della campagna. È ancora necessario selezionare una Pagina Principale personalizzata.',
        'entity'            => 'Configura questo collegamento nel menù per poter accedere direttamente ad una entità. Il campo :menu gestisce quale sotto-pagina dell\'entità sarà aperta.',
        'position'          => 'Utilizza questo campo per controllare in che ordine crescente i collegamenti appariranno nel menù.',
        'random'            => 'Utilizza questo campo per avere un collegamento rapido che punta a un\'entità a caso. È possibile filtrare il link per accedere solo a un tipo specifico di entità.',
        'selector'          => 'Configura la destinazione di questo collegamento rapido quando un utente fa clic su di esso nella barra laterale.',
        'type'              => 'Imposta questo collegamento rapido per andare direttamente a un elenco di entità. Per filtrare i risultati, copia le parti dell\'url dell\'elenco di entità filtrate dopo il segno :? nel campo :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Sottopagina del menu (utilizza l\'ultimo testo dell\'url)',
        'tab'       => '(disattivato)',
    ],
    'random_no_entity'  => 'Non è stata trovata alcuna entità casuale.',
    'random_types'      => [
        'any'   => 'Qualunque entità',
    ],
    'reorder'           => [
        'success'   => 'Collegamenti Rapidi riordinati.',
        'title'     => 'Riordina i Collegamenti Rapidi',
    ],
    'show'              => [],
    'visibilities'      => [
        'is_active' => 'Visualizza i Collegamenti Rapidi nella Barra Laterale',
    ],
];
