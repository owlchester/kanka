<?php

return [
    'create'        => [
        'title' => 'Nuovo Elemento del Menù',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Elemento del menù \':name\'',
    ],
    'fields'        => [
        'entity'    => 'Entità',
        'filters'   => 'Filtri',
        'menu'      => 'Menù',
        'position'  => 'Posizione',
        'type'      => 'Tipo di entità',
    ],
    'helpers'       => [
        'entity'    => 'Configura questo collegamento nel menù per poter accedere direttamente ad una entità. Il campo :tab gestisce quale delle delle schede dell\'entità sarà aperta. Il campo :menu gestisce quale sotto-pagina dell\'entità sarà aperta.',
        'position'  => 'Utilizza questo campo per controllare in che ordine crescente i link appariranno nel menù.',
        'type'      => 'Configura questo collegamento nel menù per poter accedere direttamente ad una lista di entità. Per filtrare i risultati, copia parti dell\'URL sulla lista filtrata delle entità dopo il segno :? nel campo :filter.',
    ],
    'index'         => [],
    'placeholders'  => [
        'entity'    => 'Seleziona un\'entità',
        'filters'   => 'Esempio: location_id=15&type=city',
        'menu'      => 'Sottopagina del menù (utilizza l\'ultimo pezzo di testo dell\'url)',
        'name'      => 'Titolo dell\'elemento del menù',
        'tab'       => 'entità, relazioni, note',
    ],
    'show'          => [],
];
