<?php

return [
    'create'        => [
        'title' => 'Nový záznam v denníku',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Dátum',
    ],
    'helpers'       => [
        'journals'          => 'Zobrazí všetky alebo len priamo podradené denníky tohto denníka.',
        'nested_without'    => 'Zobraziť všetky denníky, ktoré nemajú nadradený denník. Kliknutím na riadok zobrazíš podradené denníky.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Kto napísal tento záznam',
        'date'      => 'Reálny dátum tohto záznamu',
        'type'      => 'sedenie, one shot, návrh',
    ],
    'show'          => [],
];
