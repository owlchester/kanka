<?php

return [
    'failed'    => 'Los datos introducidos no coinciden con ningún usuario registrado.',
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Contraseña',
        ],
        'login_with_facebook'   => 'Acceder con Facebook',
        'login_with_google'     => 'Acceder con Google',
        'login_with_twitter'    => 'Acceder con Twitter',
        'new_account'           => 'Crear cuenta',
        'or'                    => 'O',
        'password_forgotten'    => '¿Olvidaste tu contraseña?',
        'remember_me'           => 'Recordar',
        'submit'                => 'Acceder',
        'title'                 => 'Acceder',
    ],
    'register'  => [
        'already_account'           => '¿Ya tienes una cuenta?',
        'email'                     => [
            'body'  => '<p>¡Bienvenido a kanka.io</p><p>Tu cuenta ha sido asociada con tu correo electronico</p>',
            'login' => 'Crear',
            'title' => '¡Bienvenido a kanka.io!',
        ],
        'errors'                    => [
            'email_already_taken'   => 'Ya existe una cuenta asociada a este correo electronico.',
            'general_error'         => 'Ha ocurrido un error mientras se registraba la cuenta. Inténtalo de nuevo.',
        ],
        'fields'                    => [
            'email'                 => 'Correo electrónico',
            'name'                  => 'Usuario',
            'password'              => 'Contraseña',
            'password_confirmation' => 'Confirma la contraseña',
            'tos'                   => 'Acepto los términos de la <a href=":privacyUrl" target="_blank">Política de Privacidad</a>.',
        ],
        'register_with_facebook'    => 'Registrarse con Facebook',
        'register_with_google'      => 'Registrarse con Google',
        'register_with_twitter'     => 'Registrarse con Twitter',
        'submit'                    => 'Crear cuenta',
        'title'                     => 'Crear cuenta',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Dirección de correo electronico',
            'password'              => 'Contraseña',
            'password_confirmation' => 'Confirma la contraseña',
        ],
        'send'      => 'Enviar enlace para restablecer la contraseña',
        'submit'    => 'Restablecer contraseña',
        'title'     => 'Restablecer contraseña',
    ],
    'throttle'  => 'Demasiados intentos de acceso. Por favor inténtelo en :seconds segundos.',
];
