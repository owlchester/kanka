<?php

return [
    'create'        => [
        'title' => 'Nuovo Evento',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Gli eventi che hanno questa entità come evento genitore sono visualizzati qui.',
    ],
    'fields'        => [
        'date'  => 'Data',
    ],
    'helpers'       => [
        'date'              => 'Questo campo può contenere qualsiasi cosa e non è collegato ai calendari della campagna. Per collegare questo evento a un calendario, aggiungilo al calendario o alla sottopagina dei promemoria di questo evento.',
        'nested_without'    => 'Visualizzazione di tutti gli eventi che non hanno un evento genitore. Fai clic su una riga per visualizzare gli eventi figli.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Una data per il tuo evento',
        'type'  => 'Cerimonia, Festival, Disastro, Battaglia, Nascita',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Elementi del Calendario',
    ],
];
