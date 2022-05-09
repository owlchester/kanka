<?php

return [
    'actions'       => [
        'mode-map'      => 'Explorador de relacións',
        'mode-table'    => 'Táboa de relacións e conexións',
    ],
    'bulk'          => [
        'delete'    => '{1} Eliminada :count relación.|[2,*] Eliminadas :count relacións.',
        'success'   => [
            'editing'           => '{1} :count relación actualizada.|[2,*] :count relacións actualizadas.',
            'editing_partial'   => '{1} :count/:total relación actualizada.|[2,*] :count/:total relacións actualizadas.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Punto de mapa',
        'mention'           => 'Mención',
        'quest_element'     => 'Elemento de misión',
        'timeline_element'  => 'Elemento de liña temporal',
    ],
    'create'        => [
        'new_title' => 'Nova relación',
        'success'   => 'Relación ":target" engadida a :entity.',
        'title'     => 'Nova relación para :name',
    ],
    'destroy'       => [
        'success'   => 'Relación ":target" eliminada de :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Actitude',
        'connection'        => 'Conexión',
        'is_star'           => 'Fixada',
        'owner'             => 'Fonte',
        'relation'          => 'Relación',
        'target'            => 'Obxectivo',
        'target_relation'   => 'Relación para o obxectivo',
        'two_way'           => 'Crear relación reflectida',
    ],
    'helper'        => 'Establece relacións entre entidades con actitude e visibilidade. As relacións poden ser fixadas ao menú da entidade.',
    'helpers'       => [
        'no_relations'  => 'Esta entidade non ten ningunha relación con outras entidades desta campaña.',
        'popup'         => 'As entidades da campaña poden ser ligadas usando relacións. Estas poden ter unha descrición, valoración de atitude, control sobre quen pode ver a relación, e máis.',
    ],
    'hints'         => [
        'attitude'          => 'As relacións aparecerán ordenadas de forma descendente segundo este campo.',
        'mirrored'          => [
            'text'  => 'Esta relación está reflectida en :link.',
            'title' => 'Reflectida',
        ],
        'target_relation'   => 'A descrición da relación no obxectivo. Déixaa en branco para que use a mesma.',
        'two_way'           => 'Ao reflectir unha relación, a mesma relación será creada na entidade obxectivo. Unha vez creada, podes editalas sen que unha sexa afectada pola outra.',
    ],
    'index'         => [
        'title' => 'Relacións',
    ],
    'options'       => [
        'mentions'  => 'Relacións + relacionadas + mencións',
        'related'   => 'Relacións + relacionadas',
        'relations' => 'Relacións',
        'show'      => 'Mostrar',
    ],
    'panels'        => [
        'related'   => 'Relacionadas',
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
