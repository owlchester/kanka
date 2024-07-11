<?php

return [
    'banned'    => [
        'permanent' => 'Has sido baneado permanentemente.',
        'temporary' => '{1} Has sido baneado por :days dia.|[2,*] Has sido baneado por :days dias.',
    ],
    'confirm'   => [
        'confirm'   => 'Confirmar',
        'error'     => 'Contraseña no válida, inténtalo de nuevo.',
        'helper'    => 'Por favor confirma tu contraseña antes de continuar.',
        'title'     => 'Confirmación de contraseña.',
    ],
    'failed'    => 'Los datos introducidos no coinciden con ningún usuario registrado.',
    'helpers'   => [
        'password'  => 'Mostrar/ocultar contraseña',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Contraseña de un solo uso',
            'email'     => 'Email',
            'password'  => 'Contraseña',
        ],
        'login_with_facebook'   => 'Acceder con Facebook',
        'login_with_google'     => 'Acceder con Google',
        'new_account'           => 'Crear cuenta',
        'or'                    => 'o bien',
        'password_forgotten'    => '¿Olvidaste tu contraseña?',
        'remember_me'           => 'Recordar',
        'submit'                => 'Acceder',
        'title'                 => 'Acceder',
    ],
    'register'  => [
        'already'                   => 'Contraseña de un solo uso',
        'errors'                    => [
            'email_already_taken'   => 'Ya existe una cuenta asociada a este correo electrónico.',
            'general_error'         => 'Ha ocurrido un error mientras se registraba la cuenta. Inténtalo de nuevo.',
        ],
        'fields'                    => [
            'email'     => 'Correo electrónico',
            'name'      => 'Usuario',
            'password'  => 'Contraseña',
            'tos_clean' => 'Acepto los :privacy',
        ],
        'log-in'                    => 'Iniciar sesión',
        'register_with_facebook'    => 'Registrarse con Facebook',
        'register_with_google'      => 'Registrarse con Google',
        'submit'                    => 'Registrarse',
        'title'                     => 'Registrarse',
        'tos'                       => 'Al registrar una cuenta, usted acepta nuestros :terms y :privacy.',
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
    'tfa'       => [
        'helper'    => 'La autenticación de dos factores está activada. Introduzca la contraseña de un solo uso (OTP) proporcionada por su aplicación de autenticación.',
        'title'     => 'Autenticación de dos factores',
    ],
    'throttle'  => 'Demasiados intentos de acceso. Por favor inténtelo en :seconds segundos.',
];
