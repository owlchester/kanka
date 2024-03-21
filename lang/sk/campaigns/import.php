<?php

return [
    'actions'       => [
        'import'    => 'Nahrať export',
    ],
    'description'   => 'Importuje objekty, poznámky, atribúty, galériu a ďalšie elementy exportovanej kampane do tejto kampane. Udeje sa to v pozadí a môže to trvať, takže si môžete uvariť zatiaľ čaj či kávu. Všetci admini budú upozornení o ukončení procesu importu.',
    'fields'        => [
        'file'      => 'Exportovaný ZIP súbor',
        'updated'   => 'Posledná aktulizácia',
    ],
    'limitation'    => 'Akceptované sú iba ZIP súbory. Max :size.',
    'status'        => [
        'failed'    => 'Zlyhaný',
        'finished'  => 'Ukončený',
        'queued'    => 'V čakačke',
        'running'   => 'Prebieha',
    ],
    'title'         => 'Import',
];
