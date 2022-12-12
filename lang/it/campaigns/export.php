<?php

return [
    'actions'   => [
        'export'    => 'Esporta i dati della campagna',
    ],
    'errors'    => [
        'limit' => 'La campagna è stata già esportata una volta oggi. Per favore riprova domani.',
    ],
    'helpers'   => [
        'import'    => 'Queste esportazioni non possono essere reimportate e sono pensate per la tua serenità o se non intendi più utilizzare Kanka. Per un\'esperienza di esportazione e importazione più solida, consulta :api.',
        'intro'     => 'Una campagna può essere esportata una volta al giorno dagli amministratori della campagna. Questa operazione genera due file zip in background. Il primo file zip contiene tutte le entità della campagna, mentre il secondo file zip contiene tutte le immagini. Riceverai una notifica su Kanka non appena i file zip saranno pronti per essere scaricati.',
        'json'      => 'Il contenuto esportato è fornito nel formato file JSON. JSON è un formato testuale e lo puoi aprire in un editor di testo o nel browser.',
    ],
    'success'   => 'L\'esportazione della campagna è in fase di preparazione. Riceverai una notifica su Kanka una volta che è pronta per scaricare.',
    'title'     => 'Esportazione della campagna',
];
