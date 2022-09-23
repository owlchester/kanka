<?php

return [
    'actions'   => [
        'export'    => 'Eksportuj dane kampanii',
    ],
    'errors'    => [
        'limit' => 'Dzisiaj już eksportowano kampanię. Spróbuj ponownie jutro.',
    ],
    'helpers'   => [
        'import'    => 'Wyeksportowanych w ten sposób danych nie można ponownie importować: eksportuje się je dla bezpieczeństwa, albo jeśli rezygnujesz z używania Kanki. Bardziej wszechstronne opcje importu i eksportu znajdziesz w :api.',
        'intro'     => 'Administrator kampanii może ją wyeksportować raz dziennie. Tworzy wówczas dwa pliki zip: pierwszy zawiera opis wszystkich elementów, a drugi ilustracje. Otrzymasz powiadomienie gdy tylko Kanka zakończy kompresję i pliki można będzie pobrać.',
        'json'      => 'Pliki wyeksportowane zostają w formacie JSON. Ponieważ zawierają dane tekstowe, można je otworzyć każdym edytorem tekstu.',
    ],
    'success'   => 'Przygotowanie do eksportu kampanii. Otrzymasz powiadomienie, gdy pliki będą gotowe do pobrania.',
    'title'     => 'Eksport kampanii',
];
