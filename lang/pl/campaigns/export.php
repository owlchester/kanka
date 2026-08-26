<?php

return [
    'actions'   => [
        'download'  => 'Pobierz',
        'export'    => 'Eksportuj kampanię',
    ],
    'confirm'   => [
        'notification'  => 'Uczestnicy w roli :admin zostaną powiadomieni, gdy eksport będzie gotowy do pobrania.',
        'title'         => 'Eksport :name',
        'type'          => 'Typ eksportu',
        'warning'       => 'Zaraz wyeksportujesz dane kampanii. To może potrwać dłuższą chwilę, zależnie od jej rozmiaru. Podczas generowania pliku możesz normalnie używać Kanki - otrzymasz powiadomienie, gdy będzie gotowy.',
    ],
    'errors'    => [
        'limit'     => 'Dzisiaj już eksportowano kampanię. Spróbuj ponownie jutro.',
        'premium'   => 'Eksort markdown jest dostępny wyłącznie w kampaniach premium.',
    ],
    'expired'   => 'Link wygasł',
    'helpers'   => [
        'json'      => 'Do archiwizacji i przywracania - można użyć w celu zaimportowania kampanii',
        'markdown'  => 'Do czytania i rozpowszechniania - format zrozumiały dla ludzi',
        'premium'   => 'Dostępne tylko w kampaniach premium.',
    ],
    'progress'  => 'Postęp',
    'size'      => 'Rozmiar',
    'status'    => [
        'failed'    => 'Niepowodzenie',
        'finished'  => 'Zakończono',
        'running'   => 'W toku',
        'scheduled' => 'Zaplanowano',
    ],
    'success'   => 'Przygotowanie do eksportu kampanii. Otrzymasz powiadomienie, gdy pliki będą gotowe do pobrania.',
    'title'     => 'Eksport kampanii',
    'type'      => 'Typ',
    'types'     => [
        'json'  => 'JSON',
        'md'    => 'Markdown',
    ],
];
