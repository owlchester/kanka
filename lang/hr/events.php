<?php

return [
    'create'        => [
        'title' => 'Novi događaj',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [],
    'fields'        => [
        'date'  => 'Datum',
    ],
    'helpers'       => [
        'date'              => 'Ovo polje može sadržavati bilo što i nije povezano s kalendarima kampanje. Da bi ovaj događaj bio povezan s kalendarom, dodaj ga u kalendar ili na karticu podsjetnika ovog događaja.',
        'nested_without'    => 'Prikaz svih događaja koji nemaju događaj roditelj. Klikni redak da bi vidio/la događaje djecu.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Datum za događaj',
        'type'  => 'Ceremonija, Festival, Nesreća, Bitka, Rođenje',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Unosi kalendara',
    ],
];
