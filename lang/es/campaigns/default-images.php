<?php

return [
    'actions'           => [
        'add'   => 'Añadir nueva imagen por defecto',
    ],
    'call-to-action'    => 'Sube una miniatura personalizada para todos los personajes, ubicaciones u otras entidades de la campaña. Estas imágenes se muestran en varias listas.',
    'create'            => [
        'error'     => 'Error al guardar las nuevas imágenes por defecto. ¿Has olvidado añadir un :type?',
        'helper'    => 'Sube una imagen que se usará como miniatura predeterminada para las entidades del módulo seleccionado.',
        'success'   => 'Imagen por defecto para :type creada.',
        'title'     => 'Nueva imagen por defecto',
    ],
    'cta'               => [
        'lead'  => 'Asigna una miniatura predeterminada a cada personaje, ubicación u otra categoría para que tus listas nunca se vean vacías.',
        'title' => 'Mantén impecable el aspecto de cada entrada.',
    ],
    'destroy'           => [
        'success'   => 'Imagen por defecto para :type eliminada.',
    ],
    'empty'             => [
        'description'   => 'Añade una imagen predeterminada a una categoría y las entradas sin imágenes personalizadas la usarán automáticamente.',
        'title'         => 'Aún no hay imágenes de marcador de posición',
    ],
    'helper'            => 'Se usa para todas las entidades de este módulo que no tengan imagen.',
    'index'             => [],
    'reset'             => [
        'helper'    => '¿Estás seguro de que deseas eliminar las imágenes predeterminadas de todos los módulos de la campaña?',
        'success'   => 'Las imágenes predeterminadas de todos los módulos se eliminaron correctamente.',
        'title'     => 'Restablecer imágenes predeterminadas',
        'warning'   => 'Esta acción es permanente y no se puede deshacer.',
    ],
    'title'             => 'Imágenes predeterminadas',
    'tutorial'          => 'Establece imágenes predeterminadas para las entidades sin imágenes personalizadas. Estas miniaturas aparecen de inmediato en toda la campaña y mantienen las listas visualmente consistentes.',
];
