<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'              => ':attribute debe ser aceptado.',
    'active_url'            => ':attribute no es una URL válida.',
    'after'                 => ':attribute debe ser una fecha posterior a :date.',
    'after_or_equal'        => ':attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                 => ':attribute sólo debe contener letras.',
    'alpha_dash'            => ':attribute sólo debe contener letras, números y guiones.',
    'alpha_num'             => ':attribute sólo debe contener letras y números.',
    'array'                 => ':attribute debe ser un conjunto.',
    'before'                => ':attribute debe ser una fecha anterior a :date.',
    'before_or_equal'       => ':attribute debe ser una fecha anterior o igual a :date.',
    'between'               => [
        'array'     => ':attribute tiene que tener entre :min - :max ítems.',
        'file'      => ':attribute debe pesar entre :min - :max kilobytes.',
        'numeric'   => ':attribute tiene que estar entre :min - :max.',
        'string'    => ':attribute tiene que tener entre :min - :max caracteres.',
    ],
    'boolean'               => 'El campo :attribute debe tener un valor verdadero o falso.',
    'confirmed'             => 'La confirmación de :attribute no coincide.',
    'date'                  => ':attribute no es una fecha válida.',
    'date_format'           => ':attribute no corresponde al formato :format.',
    'different'             => ':attribute y :other deben ser diferentes.',
    'digits'                => ':attribute debe tener :digits dígitos.',
    'digits_between'        => ':attribute debe tener entre :min y :max dígitos.',
    'dimensions'            => 'Las dimensiones de la imagen :attribute no son válidas.',
    'distinct'              => 'El campo :attribute contiene un valor duplicado.',
    'email'                 => ':attribute no es un correo válido',
    'exists'                => ':attribute es inválido.',
    'file'                  => 'El campo :attribute debe ser un archivo.',
    'filled'                => 'El campo :attribute es obligatorio.',
    'hash'                  => ':attribute no coincide con la contraseña actual.',
    'image'                 => ':attribute debe ser una imagen.',
    'in'                    => ':attribute es inválido.',
    'in_array'              => 'El campo :attribute no existe en :other.',
    'integer'               => ':attribute debe ser un número entero.',
    'ip'                    => ':attribute debe ser una dirección IP válida.',
    'ipv4'                  => ':attribute debe ser un dirección IPv4 válida',
    'ipv6'                  => ':attribute debe ser un dirección IPv6 válida.',
    'json'                  => 'El campo :attribute debe tener una cadena JSON válida.',
    'max'                   => [
        'array'     => ':attribute no debe tener más de :max elementos.',
        'file'      => ':attribute no debe ser mayor que :max kilobytes.',
        'numeric'   => ':attribute no debe ser mayor a :max.',
        'string'    => ':attribute no debe ser mayor que :max caracteres.',
    ],
    'mimes'                 => ':attribute debe ser un archivo con formato: :values.',
    'mimetypes'             => ':attribute debe ser un archivo con formato: :values.',
    'min'                   => [
        'array'     => ':attribute debe tener al menos :min elementos.',
        'file'      => 'El tamaño de :attribute debe ser de al menos :min kilobytes.',
        'numeric'   => 'El tamaño de :attribute debe ser de al menos :min.',
        'string'    => ':attribute debe contener al menos :min caracteres.',
    ],
    'not_in'                => ':attribute es inválido.',
    'numeric'               => ':attribute debe ser numérico.',
    'present'               => 'El campo :attribute debe estar presente.',
    'regex'                 => 'El formato de :attribute es inválido.',
    'required'              => 'El campo :attribute es obligatorio.',
    'required_if'           => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless'       => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with'         => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'     => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without'      => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all'  => 'El campo :attribute es obligatorio cuando ninguno de :values estén presentes.',
    'same'                  => ':attribute y :other deben coincidir.',
    'size'                  => [
        'array'     => ':attribute debe contener :size elementos.',
        'file'      => 'El tamaño de :attribute debe ser :size kilobytes.',
        'numeric'   => 'El tamaño de :attribute debe ser :size.',
        'string'    => ':attribute debe contener :size caracteres.',
    ],
    'string'                => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'              => 'El :attribute debe ser una zona válida.',
    'unique'                => ':attribute ya ha sido registrado.',
    'uploaded'              => 'Subir :attribute ha fallado.',
    'url'                   => 'El formato :attribute es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'    => [
        'attribute-name'    => [
            'rule-name' => 'custom-message',
        ],
        'email'             => [
            'unique'    => 'El :attribute ya ha sido registrado.',
        ],
        'password'          => [
            'min'   => 'La :attribute debe contener más de :min caracteres',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'    => [
        'address'               => 'dirección',
        'age'                   => 'edad',
        'available'             => 'disponible',
        'body'                  => 'contenido',
        'city'                  => 'ciudad',
        'content'               => 'contenido',
        'country'               => 'país',
        'date'                  => 'fecha',
        'day'                   => 'día',
        'description'           => 'descripción',
        'email'                 => 'correo electrónico',
        'excerpt'               => 'extracto',
        'first_name'            => 'nombre',
        'gender'                => 'género',
        'hour'                  => 'hora',
        'last_name'             => 'apellido',
        'message'               => 'mensaje',
        'minute'                => 'minuto',
        'mobile'                => 'móvil',
        'month'                 => 'mes',
        'name'                  => 'nombre',
        'password'              => 'contraseña',
        'password_confirmation' => 'confirmación de la contraseña',
        'phone'                 => 'teléfono',
        'second'                => 'segundo',
        'sex'                   => 'sexo',
        'size'                  => 'tamaño',
        'subject'               => 'asunto',
        'time'                  => 'hora',
        'title'                 => 'título',
        'username'              => 'usuario',
        'year'                  => 'año',
    ],
];
