<?php

return [
    'failed'    => 'Los datos introducidos no coinciden con ningún usuario registrado.',
    'helpers'   => [
        'password'  => 'Mostrar/ocultar contraseña',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Contraseña',
        ],
        'login_with_facebook'   => 'Acceder con Facebook',
        'login_with_google'     => 'Acceder con Google',
        'login_with_twitter'    => 'Acceder con Twitter',
        'new_account'           => 'Crear cuenta',
        'or'                    => 'o bien',
        'password_forgotten'    => '¿Olvidaste tu contraseña?',
        'remember_me'           => 'Recordar',
        'submit'                => 'Acceder',
        'title'                 => 'Acceder',
    ],
    'register'  => [
        'already_account'           => '¿Ya tienes una cuenta?',
        'email'                     => [
            'body'  => '<p>¡Te damos la bienvenida a kanka.io!</p><p>Tu cuenta ha sido asociada con tu correo electrónico.</p>',
            'login' => 'Entrar',
            'title' => 'Primeros pasos en Kanka',
        ],
        'errors'                    => [
            'email_already_taken'   => 'Ya existe una cuenta asociada a este correo electrónico.',
            'general_error'         => 'Ha ocurrido un error mientras se registraba la cuenta. Inténtalo de nuevo.',
        ],
        'fields'                    => [
            'email'     => 'Correo electrónico',
            'name'      => 'Usuario',
            'password'  => 'Contraseña',
            'tos'       => 'Acepto los términos de la <a href=":privacyUrl" target="_blank">Política de Privacidad</a>.',
        ],
        'register_with_facebook'    => 'Registrarse con Facebook',
        'register_with_google'      => 'Registrarse con Google',
        'register_with_twitter'     => 'Registrarse con Twitter',
        'submit'                    => 'Registrarse',
        'title'                     => 'Registrarse',
        'welcome_email'             => [
            'header'        => '¡Te damos la bienvenida a Kanka, :name!',
            'header_sub'    => '¡Enhorabuena! Has completado el primer paso en la creación de tu mundo en :kanka.',
            'section_1'     => '¿Qué hago ahora?',
            'section_10'    => 'Patrons',
            'section_11'    => 'Crea tu mundo,',
            'section_2'     => 'El recurso más importante es :discord, donde encontrarás a muchos de nuestros dedicados usuarios, un equipo de bienvenida y al fundador de Kanka, que pueden contestar cualquier pregunta que tengas.',
            'section_3'     => 'Nuestras :faq también cubren las preguntas más recurrentes.',
            'section_4'     => 'Nuestro :youtube tiene vídeos que cubren los básicos de Kanka. Aunque no todos los temas están explicados aún, añadimos nuevos vídeos regularmente.',
            'section_5'     => 'Canal de Youtube',
            'section_6'     => 'Contacta con nosotros',
            'section_7'     => 'Si no encuentras respuesta a tus preguntas, o simplemente quieres ponerte en contacto, puedes encontrarnos en :facebook o enviarnos un correo a :email. Somos un pequeño equipo de 2 amigos, pero nos aseguramos de que todos los mails tengan respuesta, así que no lo dudes!',
            'section_8'     => 'Y por último',
            'section_9'     => 'Nos hemos asegurado de que todas las funciones principales de Kanka sean gratuitas, y siempre las mantendremos así. Sin embargo, si quieres apoyarnos en este proyecto, puedes unirte a los :patrons y ganar así acceso a funciones adicionales, así como ganarte nuestra eterna gratitud!',
            'title'         => 'Por dónde empezar en Kanka',
        ],
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
