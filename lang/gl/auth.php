<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'banned'    => [
        'permanent' => 'Fuches expulsade permanentemente.',
        'temporary' => '{1} Levas expulsade :days día|[2,*] Levas expulsade :days días.',
    ],
    'confirm'   => [
        'confirm'   => 'Confirmar',
        'error'     => 'Contrasinal inválido, proba de novo.',
        'helper'    => 'Confirma o teu contrasinal antes de continuar.',
        'title'     => 'Confirmación do contrasinal',
    ],
    'failed'    => 'Estas credenciais non coinciden cos nosos rexistros.',
    'helpers'   => [
        'password'  => 'Mostrar / Ocultar contrasinal',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Contrasinal de uso único',
            'email'     => 'Enderezo de correo electrónico',
            'password'  => 'Contrasinal',
        ],
        'login_with_facebook'   => 'Iniciar sesión con Facebook',
        'login_with_google'     => 'Iniciar sesión cón Google',
        'new_account'           => 'Rexistrar unha conta nova',
        'or'                    => 'OU',
        'password_forgotten'    => 'Esqueciches o teu contrasinal?',
        'remember_me'           => 'Lémbrame',
        'submit'                => 'Iniciar sesión',
        'title'                 => 'Iniciar sesión',
    ],
    'register'  => [
        'errors'                    => [
            'email_already_taken'   => 'Xa existe unha conta con este enderezo de correo electrónico.',
            'general_error'         => 'Produciuse un erro ao rexistrar a túa conta. Por favor, inténtao de novo.',
        ],
        'fields'                    => [
            'email'     => 'Enderezo de correo electrónico',
            'name'      => 'Nome da conta',
            'password'  => 'Contrasinal',
            'tos_clean' => 'Acepto a :privacy',
        ],
        'register_with_facebook'    => 'Rexistrarse con Facebook',
        'register_with_google'      => 'Rexistrarse con Google',
        'submit'                    => 'Rexistrarse',
        'title'                     => 'Rexistrarse',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Enderezo de correo electrónico',
            'password'              => 'Contrasinal',
            'password_confirmation' => 'Confirma o teu contrasinal',
        ],
        'send'      => 'Enviar ligazón de restablecemento do contrasinal',
        'submit'    => 'Restablecer contrasinal',
        'title'     => 'Restablecer contrasinal',
    ],
    'tfa'       => [
        'helper'    => 'A autentificación en dous factores está activada. Por favor, introduce o contrasinal de uso único (OTP) proporcionada pola túa aplicación de autentificación.',
        'title'     => 'Autentificación en dous factores',
    ],
    'throttle'  => 'Demasiados intentos de acceso. Por favor, inténtao de novo en :seconds segundos.',
];
