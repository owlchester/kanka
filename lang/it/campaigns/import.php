<?php

return [
    'actions'       => [
        'import'    => 'Carica l\'esportazione',
    ],
    'description'   => 'Importa le entità, i post, gli attributi, la galleria e altri elementi da una campagna esportata in questa campagna. Questa operazione avviene nel backend e può richiedere un po\' di tempo, quindi prenditi un caffè. Tu e gli altri amministratori della campagna sarete avvisati quando il processo di importazione sarà terminato.',
    'fields'        => [
        'file'      => 'Esporta file ZIP',
        'updated'   => 'Ultimo aggiornamento',
    ],
    'form'          => 'Carica da',
    'limitation'    => 'Sono accettati solo file zip. Dimensione massima :size',
    'progress'      => [
        'uploading' => 'Caricamento',
        'validating'=> 'Convalida',
    ],
    'status'        => [
        'failed'    => 'Fallito',
        'finished'  => 'Finito',
        'queued'    => 'In coda',
        'running'   => 'In esecuzione',
    ],
    'title'         => 'Importa',
];
