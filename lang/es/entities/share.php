<?php

return [
    'buttons'   => [
        'copy'          => 'Copiar enlace',
        'make_public'   => 'Hacer pública la campaña',
    ],
    'fields'    => [
        'campaign_access'   => 'Configuración de campaña',
        'visibility_mode'   => 'Ajustar visibilidad',
    ],
    'helpers'   => [
        'campaign_access'               => 'Para compartir esto con el público, primero debes hacer pública la campaña.',
        'entity_permissions_warning'    => 'Hacer pública esta campaña permite que cualquiera la vea. Las entradas marcadas como privadas permanecen ocultas.',
        'hidden_explanation'            => 'La campaña es pública, pero esta entrada está actualmente oculta para los no miembros.',
        'hidden_unlisted_explanation'   => 'La campaña no está listada; solo las personas con el enlace pueden encontrarla.',
        'member-link'                   => 'Compartir esto solo con miembros',
        'private_explanation'           => 'Solo los miembros pueden acceder a esta entrada.',
        'public_explanation'            => 'Tanto la campaña como esta entrada son públicas. Cualquiera con el enlace puede verlas.',
        'unlisted_explanation'          => 'La campaña no está listada y esta entrada es visible. Cualquiera con el enlace puede verla.',
    ],
    'labels'    => [
        'member_link'   => 'Enlace solo para miembros',
        'public_link'   => 'Enlace público',
        'share_link'    => 'Enlace para compartir',
    ],
    'options'   => [
        'keep_private'          => 'Mantener campaña privada',
        'make_all_public'       => 'Mostrar todo :module a no miembros',
        'make_campaign_public'  => 'Hacer campaña pública',
        'make_entity_public'    => 'Mostrar :name a no miembros',
    ],
    'status'    => [
        'hidden'    => 'No visible para no miembros',
        'private'   => 'Esta campaña es privada',
        'public'    => 'Visible para no miembros',
        'unlisted'  => 'Visible para cualquiera con el enlace',
    ],
    'success'   => [
        'copied'            => '¡Enlace copiado al portapapeles!',
        'copied_members'    => 'Enlace solo para miembros copiado.',
        'copied_public'     => 'Enlace público copiado, cualquiera con el enlace puede ver la entrada.',
        'updated'           => 'Configuración de visibilidad actualizada exitosamente.',
    ],
    'title'     => 'Compartir entrada',
];
