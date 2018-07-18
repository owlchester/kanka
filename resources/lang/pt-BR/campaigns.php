<?php

return [
    'create'        => [
        'description'           => 'Criar uma nova Campanha',
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
        'description'   => 'Edite sua campanha',
        'success'       => 'Campanha atualizada',
        'title'         => 'Editar Campanha :campaign',
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
            'link'  => 'Novo Link',
        ],
        'create'        => [
            'button'        => 'Convidar',
            'description'   => 'Convide um amigo para a sua campanha',
            'link'          => 'Link criado: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Convite enviado.',
            'title'         => 'Convide alguém para sua campanha',
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
            'role'      => 'Cargo',
            'type'      => 'Tipo',
            'validity'  => 'Validade',
        ],
        'helpers'       => [
            'validity'  => 'Quantos usuários podem usar esse link antes que seja desativado.',
        ],
        'placeholders'  => [
            'email' => 'Email da pessoa que você deseja convidar',
        ],
        'types'         => [
            'email' => 'Email',
            'link'  => 'Link',
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
            'description'   => 'Edite um membro da sua campanha',
            'title'         => 'Editar membro :name',
        ],
        'fields'    => [
            'joined'    => 'Juntou-se em',
            'name'      => 'Usuário',
            'role'      => 'Cargo',
            'roles'     => 'Cargos',
        ],
        'help'      => 'Não há limite para o número de membros que uma campanha pode ter, e como Administrador da campanha, você pode remover membros que não estão mais ativos nela.',
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
    'roles'         => [
        'actions'       => [
            'add'   => 'Adicione um cargo',
        ],
        'create'        => [
            'success'   => 'Cargo criado',
            'title'     => 'Criar um novo cargo para :name',
        ],
        'destroy'       => [
            'success'   => 'Cargo removido.',
        ],
        'edit'          => [
            'success'   => 'Cargo atualizado',
            'title'     => 'Editar Cargo :name',
        ],
        'fields'        => [
            'name'          => 'Nome',
            'permissions'   => 'Permissões',
            'users'         => 'Usuários',
        ],
        'helper'        => [
            '1' => 'Uma campanha pode ter quantos cargos quiser. O cargo de "Administrador" tem automaticamente acesso a tudo de uma campanha, mas cada outro cargo pode ter permissões específicas em cada tipo de entidade (personagem, local, etc).',
            '2' => 'Entidades podem ter permissões mais refinadas visualizando a aba "Permissões" dessa entidade. Essa aba aparece uma vez que sua campanha tenha vários cargos ou membros.',
            '3' => 'Pode-se optar pelo sistema de "exclusão", onde o acesso para visualização de todas as entidades é dado aos cargos, e usar a caixa de seleção "Privado" nas entidades para escondê-las. Ou pode-se optar por não dar aos cargos muitas permissões, mas configurar cada entidade ser visível individualmente.',
        ],
        'hints'         => [
            'role_permissions'  => 'Habilitar o cargo \':name\' a fazer as seguintes ações em todas as entidades.',
        ],
        'members'       => 'Membros',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Criar',
                'delete'        => 'Deletar',
                'edit'          => 'Editar',
                'permission'    => 'Gerenciar Permissões',
                'read'          => 'Ver',
            ],
            'hint'      => 'Esse cargo tem automaticamente acesso a tudo.',
        ],
        'placeholders'  => [
            'name'  => 'Nome do cargo',
        ],
        'show'          => [
            'description'   => 'Membros e Permissões do cargo da campanha',
            'title'         => 'Cargo \':role\' para a campanha \':campaign\'',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Adicionar',
            ],
            'create'    => [
                'success'   => 'Usuário adicionado ao cargo',
                'title'     => 'Adicione um membro para o cargo :name',
            ],
            'destroy'   => [
                'success'   => 'Usuário removido do cargo.',
            ],
            'fields'    => [
                'name'  => 'Nome',
            ],
        ],
    ],
    'settings'      => [
        'edit'      => [
            'success'   => 'Configurações da campanha atualizadas.',
        ],
        'helper'    => 'Você pode facilmente desabilitar elementos da sua campanha que serão escondidos. Se você já havia criado elementos nas categorias que desabilitar, eles não serão deletados, apenas ocultados.',
        'helpers'   => [
            'calendars'     => 'Um lugar para definir todos os calendários do seu mundo.',
            'categories'    => 'Cada entidade pode ter uma categoria. Categorias podem pertencer a outras categorias, e entidades podem ser filtradas por categorias.',
            'characters'    => 'O povo que habita seu mundo.',
            'dice_rolls'    => 'Para aqueles que usam Kanka para campanhas de RPG, uma maneira de cuidar das rolagens de dados.',
            'events'        => 'Feriados, festivais, desastres, aniversários, guerras.',
            'families'      => 'Clãs ou famílias, suas relações e seus membros.',
            'items'         => 'Armas, veículos, relíquias, poções.',
            'journals'      => 'Observações escritas por personagens, ou preparações de sessões para o mestre do jogo.',
            'locations'     => 'Planetas, planos, continentes, rios, estados, acampamentos, templos, tavernas.',
            'menu_links'    => 'Links de menus personalizados na barra lateral.',
            'notes'         => 'História, religião, magia, raças.',
            'organisations' => 'Cultos, uniões militares, facções, guildas',
            'quests'        => 'Para manter controle de várias missões com personagens e locais.',
        ],
    ],
    'show'          => [
        'actions'       => [
            'leave' => 'Deixar campanha',
        ],
        'description'   => 'Uma visão detalhada da campanha',
        'tabs'          => [
            'information'   => 'Informações',
            'members'       => 'Membros',
            'roles'         => 'Cargos',
            'settings'      => 'Configurações',
        ],
        'title'         => 'Campanha :name',
    ],
];
