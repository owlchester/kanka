<?php

return [
    'actions'       => [
        'import'    => 'Załaduj wyeksportowane',
    ],
    'description'   => 'Importuje elementy, wpisy, cechy, galerię i inne elementy wyeksportowanej kampanii do innej kampanii. Proces działa w tle i zajmuje dobrą chwilę, więc przygotuj sobie kawę. Gdy się zakończy, ty i pozostali administratorzy zostaniecie o tum powiadomieni.',
    'fields'        => [
        'file'      => 'Eksportuj plik ZIP',
        'updated'   => 'Ostatnio zmienione',
    ],
    'form'          => 'Załaduj z',
    'limitation'    => 'Dozwolone są tylko pliki zip do rozmiaru :size.',
    'progress'      => [
        'uploading' => 'Ładowanie',
        'validating'=> 'Weryfikacja',
    ],
    'status'        => [
        'failed'    => 'Niepowodzenie',
        'finished'  => 'Zakończono',
        'queued'    => 'W kolejce',
        'running'   => 'W toku',
    ],
    'title'         => 'Import',
];
