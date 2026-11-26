<?php

return [
    'actions'       => [
        'status'    => 'Estado: :status',
    ],
    'create'        => [
        'helper'    => 'Crea un nuevo rol para la campaña.',
    ],
    'overview'      => [
        'limited'   => ':amount de :total roles creados.',
        'title'     => 'Roles disponibles',
        'unlimited' => ':amount de roles ilimitados creados.',
    ],
    'permissions'   => [
        'campaign-features' => 'Funciones de la campaña',
        'content-modules'   => 'Módulos de contenido',
        'toggle'            => [
            'action'    => 'Cambiar todo',
            'tooltip'   => 'Cambiar el permiso :action para todos los módulos.',
        ],
    ],
    'public'        => [
        'actions'               => [
            'disable_all'   => 'Desactivar todo',
            'enable_all'    => 'Activar todo',
        ],
        'disabled_categories'   => [
            'helper'    => 'Estas categorías están desactivadas en la configuración de tu campaña. Los cambios de acceso público que hagas aquí se aplicarán si vuelves a activarlas.',
            'title'     => 'Categorías desactivadas (:count)',
        ],
        'helpers'               => [
            'click'     => 'Haz clic en cualquier módulo para cambiar el acceso público a todas las entidades que contiene.',
            'intro'     => 'Controla lo que los no miembros pueden ver en la campaña.',
            'main'      => 'Selecciona qué módulos son visibles para cualquiera que vea la campaña, tanto si ha iniciado sesión como si no. Esto incluye a visitantes públicos y a usuarios de Kanka que no son miembros de la campaña.',
            'preview'   => 'Vista previa como no miembro',
        ],
        'private_notice'        => [
            'action'    => 'Cambiar visibilidad',
            'body'      => 'Quienes no son miembros todavía no pueden ver nada. Los cambios que hagas aquí se aplicarán cuando cambies la visibilidad de la campaña a Pública (no listada) o Pública.',
            'title'     => 'Esta campaña es privada.',
        ],
        'status'                => [
            'hidden'    => 'Oculto para visitantes',
            'visible'   => 'Visible para visitantes',
        ],
        'summary'               => ':visible de :total categorías visibles',
        'toggle_all'            => [
            'disabled'  => 'Todas las categorías están ahora ocultas para :role.',
            'enabled'   => 'Todas las categorías activas están ahora visibles para :role.',
        ],
    ],
    'show'          => [
        'title' => 'permisos de :role - :campaign',
    ],
    'standard'      => [
        'advanced'  => [
            'toggle'    => 'Mostrar permisos individuales',
        ],
        'features'  => [
            'groups'    => [
                'bookmarks' => 'Marcadores',
                'campaign'  => 'Campaña',
                'gallery'   => 'Galería',
                'templates' => 'Arquetipos y plantillas',
            ],
            'helpers'   => [
                'bookmarks'         => 'Permite administrar los marcadores de la campaña.',
                'template_articles' => 'Permite administrar las plantillas de artículos.',
                'template_entries'  => 'Permite administrar los arquetipos y las plantillas de entradas.',
            ],
        ],
        'presets'   => [
            'clear_all' => 'Borrar todo',
            'contribute'=> 'Colaborar',
            'custom'    => 'Personalizado',
            'full'      => 'Acceso total',
            'label'     => 'Aplicación rápida',
            'none'      => 'Sin acceso',
            'view'      => 'Solo lectura',
        ],
        'save_bar'  => [
            'reset'     => 'Restablecer',
            'unsaved'   => 'Tienes cambios de permisos sin guardar.',
        ],
    ],
    'toggle'        => [
        'disabled'  => 'Los miembros del rol :role ya no pueden :action :entities',
        'enabled'   => 'Los miembros del rol :role ahora pueden :action :entities',
    ],
    'warnings'      => [
        'adding-to-admin'   => 'Los miembros del rol :name tienen acceso a todo en la campaña, y no pueden ser eliminados por otros miembros del rol. Después de :amount de minutos, sólo ellos pueden darse de baja del rol.',
    ],
];
