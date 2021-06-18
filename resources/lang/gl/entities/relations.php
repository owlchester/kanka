<?php

return [
    'create'        => [
        'success'   => 'Relación ":target" engadida a :entity.',
        'title'     => 'Nova relación para :name',
    ],
    'destroy'       => [
        'success'   => 'Relación ":target" eliminada de :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Actitude',
        'is_star'           => 'Fixada',
        'relation'          => 'Relación',
        'target'            => 'Obxectivo',
        'target_relation'   => 'Relación para o obxectivo',
        'two_way'           => 'Crear relación reflectida',
    ],
    'helper'        => 'Establece relacións entre entidades con actitude e visibilidade. As relacións poden ser fixadas ao menú da entidade.',
    'hints'         => [
        'attitude'          => 'As relacións aparecerán ordenadas de forma descendente segundo este campo.',
        'mirrored'          => [
            'text'  => 'Esta relación está reflectida en :link.',
            'title' => 'Reflectida',
        ],
        'target_relation'   => 'A descrición da relación no obxectivo. Déixaa en branco para que use a mesma.',
        'two_way'           => 'Ao reflectir unha relación, a mesma relación será creada na entidade obxectivo. Unha vez creada, podes editalas sen que unha sexa afectada pola outra.',
    ],
    'placeholders'  => [
        'attitude'  => 'De -100 a 100, sendo 100 moi positiva',
        'relation'  => 'Rival, mellor amiga, irmá...',
        'target'    => 'Escolle unha entidade',
    ],
    'show'          => [
        'title' => 'Relacións de ":name"',
    ],
    'teaser'        => 'Potencia a campaña para acceder ao diagrama de relacións. Fai clic para aprender máis sobre campañas potenciadas.',
    'types'         => [
        'family_member'         => 'Familiar',
        'organisation_member'   => 'Integrante da organización',
    ],
    'update'        => [
        'success'   => 'Relación ":target" de ":entity" actualizada.',
        'title'     => 'Actualizar as relacións de ":name"',
    ],
];
