<?php

return [
    'description'   => 'Los permisos en Kanka se pueden afinar para controlar exactamente qué puede y qué no puede ver un usuario. Puedes ser tan abierto o restrictivo como quieras, dependiendo de tus necesidades.',
    'fifth'         => 'Casi todas las entidades tienen una opción de "Privada" que reemplaza todos los demás permisos. Si está activada, solo los administradores de la campaña podrán verla.',
    'first'         => 'Los permisos de Kanka están divididos en varios conceptos: permisos de rol y permisos de entidad. Por defecto, cada campaña viene con un rol de Admin, Público y Jugador. Los miembros del rol de administrador pueden ver y hacerlo todo en la campaña. El rol público se usa si la campaña es pública y el usuario no forma parte de ella; por defecto, el rol no tiene permisos. Por último, el rol de jugador también viene sin ningún permiso por defecto, y se usa para los miembros de la campaña. Cuando invitas a un nuevo miembro a la campaña, defines qué rol tendrá cuando se una. Puedes crear más roles y cambiar el rol a los usuarios, así como hacer que un miembro tenga más de un rol.',
    'fourth'        => 'Para comprobar los permisos de un usuario, ve a la página de miembros de la campaña y haz clic en el botón de "Ver como". Este botón solo está disponible para los administradores, y solo puede usarse sobre usuarios no administradores. Al crear o editar una entidad usando esta funcionalidad, la información se verá reflejada en el registro de la entidad.',
    'second'        => 'Un rol puede configurarse de diversas formas. Por ejemplo, puedes permitir a los miembros de un rol ver y crear personajes, pero no editarlos o eliminarlos. Si un usario puede crear una entidad pero no pueden editar, automáticamente tendrá permisos para actualizarla.',
    'third'         => 'Si no quieres que los miembros de un rol vean todos los personajes, puedes configurar los permisos individualmente en cada personaje, ya sea editándolos o usando el botón de edición en grupo, visible a los administradores de la campaña. El mismo concepto se aplica a todos los demás tipos de entidad.',
    'title'         => 'Permisos',
];
