<?php

return [
    'banned'    => [
        'permanent' => 'Você foi banido permanentemente.',
        'temporary' => '{1} Você foi banido por :days dia|[2,*] Você foi banido por :days dias',
    ],
    'confirm'   => [
        'confirm'   => 'Confirmar',
        'error'     => 'Senha inválida, por favor tente novamente.',
        'helper'    => 'Por favor confirme sua senha antes de continuar.',
        'title'     => 'Confirmação da Senha',
    ],
    'failed'    => 'Essas credenciais não correspondem ao do nosso sistema.',
    'helpers'   => [
        'password'  => 'Mostrar / Esconder senha',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Senha de uso único',
            'email'     => 'Email',
            'password'  => 'Senha',
        ],
        'login_with_facebook'   => 'Entrar com o Facebook',
        'login_with_google'     => 'Entrar com o Google',
        'login_with_twitter'    => 'Entrar com o Twitter',
        'new_account'           => 'Cadastrar uma nova conta',
        'or'                    => 'Ou',
        'password_forgotten'    => 'Esqueceu sua senha?',
        'remember_me'           => 'Lembrar',
        'submit'                => 'Entrar',
        'title'                 => 'Entrar',
    ],
    'register'  => [
        'already'                   => 'Já tem uma conta? :login',
        'already_account'           => 'Já possui uma conta?',
        'errors'                    => [
            'email_already_taken'   => 'Já há uma conta registrada com esse email.',
            'general_error'         => 'Um erro ocorreu enquanto sua conta era cadastrada. Por favor tente novamente.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Usuário',
            'password'  => 'Senha',
            'tos_clean' => 'Eu concordo com :privacy',
        ],
        'log-in'                    => 'Conectar-se',
        'register_with_facebook'    => 'Cadastrar com o Facebook',
        'register_with_google'      => 'Cadastrar com o Google',
        'register_with_twitter'     => 'Cadastrar com o Twitter',
        'submit'                    => 'Cadastrar',
        'title'                     => 'Cadastrar',
        'tos'                       => 'Ao registrar uma conta, você concorda com nossos :terms e :privacy.',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Email',
            'password'              => 'Senha',
            'password_confirmation' => 'Confirme sua senha',
        ],
        'send'      => 'Enviar Link de Redefinição de Senha',
        'submit'    => 'Redefinir senha',
        'title'     => 'Redefinir senha',
    ],
    'tfa'       => [
        'helper'    => 'A autenticação de dois fatores está habilitada. Forneça a senha de uso único (OTP) fornecida pelo seu aplicativo autenticador.',
        'title'     => 'Autenticação de Dois-Fatores',
    ],
    'throttle'  => 'Muitas tentativas de login. Por favor tente novamente em :seconds segundos.',
];
