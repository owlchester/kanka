<?php

return [
    'actions'       => [
        'import'    => 'Subir la exportación',
    ],
    'description'   => 'Importa las entidades, entradas, atributos, la galería y otros elementos de una exportación de campaña a esta campaña. Esto ocurre en el backend y puede llevar un rato, así que tómate un café. Tú y los otros administradores de campaña serán notificados cuando el proceso de importación haya terminado.',
    'fields'        => [
        'file'      => 'Exportar archivo ZIP',
        'updated'   => 'Última actualización',
    ],
    'form'          => 'Formulario de carga',
    'limitation'    => 'Sólo se aceptan archivos zip. :size máximo.',
    'progress'      => [
        'uploading' => 'Subiendo',
        'validating'=> 'Validando',
    ],
    'status'        => [
        'failed'    => 'Fallida',
        'finished'  => 'Terminada',
        'queued'    => 'En cola',
        'running'   => 'Ejecutándose',
    ],
    'title'         => 'Importar',
];
