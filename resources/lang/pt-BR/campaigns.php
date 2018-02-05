<?php

return [
    'create'        => [
        'helper'                => [
            'first' => 'Muito obrigado por testar o nosso app! Antes de continuarmos, nós precisamos que você nos informe uma coisa: O nome da sua <b>Campanha</b>. Esse será o nome do seu mundo que o diferencia dos outros, então precisa ser único. Se você não pensou em um bom nome ainda, não se preocupe, você <b>sempre pode mudar depois</b>, ou criar mais campanhas.',
            'second'=> 'Mas chega de conversinha! E então, qual será?',
            'title' => 'Bem vindo a :name!',
        ],
        'success'               => 'Campanha criada.',
        'success_first_time'    => 'Sua campanha foi criada! Como é a sua primeira campanha, nós criamos algumas coisas para te ajudar e talvez lhe dar um pouco de inspiração no que você pode fazer.',
        'title'                 => 'Criar uma nova campanha',
    ],
    'destroy'       => [
        'success'   => 'Campanha removida',
    ],
    'edit'          => [
        'success'   => 'Campanha atualizada',
        'title'     => 'Editar Campanha :campaign',
    ],
    'fields'        => [
        'description'   => 'Descrição',
        'image'         => 'Imagem',
        'locale'        => 'Local',
        'name'          => 'Nome',
    ],
    'index'         => [
        'actions'       => [
            'new'   => [
                'description'   => 'Criar uma nova campanha',
                'title'         => 'Nova Campanha',
            ],
        ],
        'add'           => 'Nova Campanha',
        'description'   => 'Gerenciar suas campanhas',
        'list'          => 'Suas Campanhas',
        'select'        => 'Selecione uma Campanha',
        'title'         => 'Campanhas',
    ],
    'invites'       => [
        'actions'       => [
            'add'   => 'Convidar',
        ],
        'create'        => [
            'button'    => 'Convidar',
            'success'   => 'Convite enviado.',
            'title'     => 'Convide alguém para sua campanha',
        ],
        'destroy'       => [
            'success'   => 'Convite removido',
        ],
        'email'         => [
            'link'      => '<a href=":link">Juntar-se a campanha de :name\'s </a>',
            'subject'   => ':name convidou você para juntar-se a sua campanha \':campaign\' no kanka.io! Use o link a seguir para aceitar o seu convite.',
            'title'     => 'Convite de :name',
        ],
        'error'         => [
            'already_member'    => 'Você já é um membro dessa campanha.',
            'inactive_token'    => 'Esse token já foi utilizado, ou a campanha não existe mais.',
            'invalid_token'     => 'Esse token é inválido.',
            'login'             => 'Por favor entre ou cadastre-se para juntar-se a campanha.',
        ],
        'fields'        => [
            'created'   => 'Enviado',
            'email'     => 'Email',
        ],
        'placeholders'  => [
            'email' => 'Email da pessoa que você deseja convidar',
        ],
    ],
    'leave'         => [
        'confirm'   => 'Você tem certeza que deseja sair de :name campaign? Você não poderá acessar novamente, a não ser que o dono da campanha te convide novamente.',
        'error'     => 'Não foi possível sair da campanha.',
        'success'   => 'Você saiu da campanha.',
    ],
    'members'       => [
        'create'    => [
            'title' => 'Adicionar um membro a sua campanha',
        ],
        'edit'      => [
            'title' => 'Editar membro :name',
        ],
        'fields'    => [
            'joined'    => 'Juntou-se em',
            'name'      => 'Usuário',
            'role'      => 'Cargo',
        ],
        'invite'    => [
            'description'   => 'Você pode convidar amigos para se juntar a sua campanha fornecendo o endereço de email deles. Assim que eles aceitarem o convite, serão adicionados como um "Espectador". Você também pode cancelar o convite a qualquer momento.',
            'title'         => 'Convidar',
        ],
        'roles'     => [
            'member'    => 'Membro',
            'owner'     => 'Dono',
            'viewer'    => 'Espectador',
        ],
        'your_role' => 'Você é  <i>:role</i>',
    ],
    'placeholders'  => [
        'description'   => 'Um pequeno resumo da sua campanha',
        'locale'        => 'Idioma',
        'name'          => 'O nome da sua campanha',
    ],
    'settings'      => [
        'edit'      => [
            'success'   => 'Configurações da campanha atualizadas.',
        ],
        'helper'    => 'Você pode facilmente desabilitar elementos da sua campanha que serão escondidos. Se você já havia criado elementos nas categorias que desabilitar, eles não serão deletados, apenas ocultados.',
    ],
    'show'          => [
        'actions'       => [
            'leave' => 'Deixar campanha',
        ],
        'description'   => 'Uma visão detalhada da campanha',
        'tabs'          => [
            'information'   => 'Informações',
            'members'       => 'Membros',
            'settings'      => 'Configurações',
        ],
        'title'         => 'Campanha :name',
    ],
];
