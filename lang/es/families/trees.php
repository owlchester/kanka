<?php

return [
    'actions'   => [
        'clear'             => 'Borrar todo',
        'first'             => 'Añadir un fundador',
        'founder'           => 'Añadir un nuevo fundador',
        'rename-relation'   => 'Renombrar relación',
        'reset'             => 'Descartar cambios',
        'save'              => 'Guardar',
    ],
    'modal'     => [
        'first-title'   => 'Selecciona una entidad',
        'helper'        => 'Sustituir la entidad por otra de la campaña',
        'relation'      => 'Relación',
        'title'         => 'Reemplazar entidad',
    ],
    'modals'    => [
        'clear'     => [
            'confirm'   => '¿Estás seguro de que quieres reinicializar todos los datos del árbol genealógico?',
        ],
        'entity'    => [
            'add'       => [
                'founder'   => 'Fundador/a',
                'member'    => 'Miembro',
                'success'   => 'Entidad añadida.',
                'title'     => 'Añadir una entidad',
            ],
            'child'     => [
                'success'   => 'Descendencia añadida.',
                'title'     => 'Añadir descendencia',
            ],
            'edit'      => [
                'helper'    => 'Selecciona esta opción si la relación es desconocida. Se puede añadir un personaje más tarde.',
                'success'   => 'Entidad actualizada.',
                'title'     => 'Actualizar una entidad',
            ],
            'founder'   => [
                'title' => 'Añadir un nuevo fundador',
            ],
            'remove'    => [
                'confirm'   => '¿Estás seguro de que quieres eliminar esta entidad del árbol genealógico?',
                'success'   => 'Entidad eliminada.',
            ],
        ],
        'relations' => [
            'add'       => [
                'success'   => 'Relación añadida.',
                'title'     => 'Añadir una relación',
            ],
            'edit'      => [
                'success'   => 'Relación actualizada.',
                'title'     => 'Actualizar una relación',
            ],
            'unknown'   => 'Desconocido',
        ],
        'reset'     => [
            'confirm'   => '¿Estás seguro de que quieres descartar los cambios realizados en el árbol genealógico?',
        ],
    ],
    'pitch'     => 'Crea un árbol genealógico detallado para las familias de la campaña.',
    'success'   => [
        'cleared'   => 'Árbol genealógico borrado.',
        'reseted'   => 'El árbol genealógico se ha restablecido.',
        'saved'     => 'Árbol genealógico guardado.',
    ],
    'title'     => 'Árbol genealógico :name',
    'unknown'   => 'no establecido',
];
