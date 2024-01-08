<?php

return [
    'fields'    => [
        'type'  => 'Tipo de Lembrete',
    ],
    'helpers'   => [
        'characters'    => 'Definir o tipo como data de nascimento ou de morte para este personagem irá calcular automaticamente sua idade. :more.',
        'founding'      => 'Definir o tipo como :type calculará automaticamente a idade da entidade desde a sua fundação.',
        'no_events_v2'  => 'Essa entidade pode ser vinculada aos calendários da campanha por meio de lembretes, os quais são exibidos aqui.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Adicionar lembrete',
        ],
        'title'     => 'Lembretes :name',
    ],
    'types'     => [
        'birth'     => 'Nascimento',
        'birthday'  => 'Aniversário',
        'death'     => 'Morte',
        'founded'   => 'Fundado',
        'primary'   => 'Primário',
    ],
    'years-ago' => '{1} :count ano atrás|[2,*] :count anos atrás',
];
