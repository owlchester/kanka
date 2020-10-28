<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'SIncronizar',
        ],
        'errors'    => [
            'invalid_uuid'  => 'ID da campanha LFGM inváldo. Por favor, tente novamente.',
        ],
        'helper'    => 'Selecione uma campanha para sincronizar seus próximos eventos de :lfgm. Isso adicionará uma nota com seus próximos eventos a essas campanhas e fixará no dashbosrd da campanha.',
        'successes' => [
            'sync'  => 'Calendário LFGM sincronizado.',
        ],
        'title'     => 'Sincronização da campanha LookingForGM',
    ],
];
