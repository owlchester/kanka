<?php

return [
    'create'                            => [
        'description'           => 'Criar uma nova Campanha',
        'helper'                => [
            'first'     => 'Muito obrigado por testar o nosso app! Antes de continuarmos, nós precisamos que você nos informe uma coisa: O nome da sua <b>Campanha</b>. Esse será o nome do seu mundo que o diferencia dos outros, então precisa ser único. Se você não pensou em um bom nome ainda, não se preocupe, você <b>sempre pode mudar depois</b>, ou criar mais campanhas.',
            'second'    => 'Mas chega de conversinha! E então, qual será?',
            'title'     => 'Bem vindo a :name!',
            'welcome'   => <<<'TEXT'
Antes de prosseguir, você precisa escolher um nome de campanha. Este é o nome do seu mundo. Se você ainda não tem um bom nome, não se preocupe, você sempre pode alterá-lo mais tarde ou criar mais campanhas.

Obrigado por se juntar a Kanka e bem-vindo à nossa crescente comunidade!
TEXT
,
        ],
        'success'               => 'Campanha criada.',
        'success_first_time'    => 'Sua campanha foi criada! Como é a sua primeira campanha, nós criamos algumas coisas para te ajudar e talvez lhe dar um pouco de inspiração no que você pode fazer.',
        'title'                 => 'Criar uma nova campanha',
    ],
    'destroy'                           => [
        'success'   => 'Campanha removida',
    ],
    'edit'                              => [
        'description'   => 'Edite sua campanha',
        'success'       => 'Campanha atualizada',
        'title'         => 'Editar Campanha :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'Como padrão, novos personagens tem sua personalidade privada.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Novas entidades são privadas.',
    ],
    'errors'                            => [
        'access'        => 'Você não tem acesso a esta campanha.',
        'unknown_id'    => 'Campanha desconhecida',
    ],
    'export'                            => [
        'description'   => 'Exportar a campanha.',
        'errors'        => [
            'limit' => 'Você excedeu o máximo de uma exportação por dia. Por favor, tente novamente amanhã.',
        ],
        'helper'        => 'Exporte sua campanha. Uma notificação com um link para download será disponibilizada.',
        'success'       => 'A exportação da sua campanha está sendo preparada. Você receberá uma notificação em Kanka para um arquivo .zip para download assim que estiver pronto.',
        'title'         => 'Exportação da campanha :name',
    ],
    'fields'                            => [
        'boosted'                       => 'Impulsionada por',
        'css'                           => 'CSS',
        'description'                   => 'Descrição',
        'entity_count'                  => 'Número de entidades',
        'entity_personality_visibility' => 'Visibilidade da personalidade do personagem',
        'entity_visibility'             => 'Visibilidade da entidade',
        'excerpt'                       => 'Resumo',
        'followers'                     => 'Seguidores',
        'header_image'                  => 'Cabeçalho',
        'hide_history'                  => 'Esconder histórico da entidade',
        'hide_members'                  => 'Esconder membros da campanha',
        'image'                         => 'Imagem',
        'locale'                        => 'Local',
        'name'                          => 'Nome',
        'public_campaign_filters'       => 'Filtros de Campanhas públicas',
        'rpg_system'                    => 'SIstemas de RPG',
        'system'                        => 'Sistema',
        'theme'                         => 'Tema',
        'tooltip_family'                => 'Desativar nomes de família das dicas',
        'tooltip_image'                 => 'Mostrar imagens da entidade nas dicas',
        'visibility'                    => 'Visibilidade',
    ],
    'following'                         => 'Seguindo',
    'helpers'                           => [
        'boost_required'                => 'Este recurso requer que a campanha seja impulsionada. Mais informações na página :settings.',
        'boosted'                       => 'Alguns recursos requerem que a campanha esteja sendo impulsionada. Mais informações na página :settings.',
        'css'                           => 'Escreva seu próprio CSS que será carregado nas páginas de sua campanha. Observe que qualquer abuso desse recurso pode levar à remoção do seu CSS personalizado. Ofensas repetidas ou graves podem levar à remoção de sua campanha.',
        'entity_personality_visibility' => 'Ao criar um novo personagem, a opção "Personalidade Visível" será automaticamente desmarcada.',
        'entity_visibility'             => 'Ao criar uma nova entidade, a opção "Privada" será automaticamente selecionada.',
        'excerpt'                       => 'O resumo da campanha será exibido no painel, então escreva algumas frases apresentando o seu mundo. Mantenha-o curto para obter os melhores resultados.',
        'hide_history'                  => 'Habilite esta opção para ocultar o histórico de entidades para membros não administradores da campanha.',
        'hide_members'                  => 'Habilite esta opção para ocultar a lista de membros da campanha para membros não administradores.',
        'locale'                        => 'O idioma em que sua campanha está escrita. É usado para gerar conteúdo e agrupar campanhas públicas.',
        'name'                          => 'Sua campanha/mundo pode ter qualquer nome, desde que contenha pelo menos 4 letras ou números.',
        'public_campaign_filters'       => 'Ajude outras pessoas a encontrar a campanha entre outras campanhas públicas, fornecendo as seguintes informações.',
        'system'                        => 'Se a sua campanha estiver publicamente visível, o sistema será mostrado na página :link.',
        'systems'                       => 'Para evitar sobrecarregar os usuários com opções, alguns recursos do Kanka estão disponíveis apenas com sistemas de RPG específicos (ou seja, o bloco de estatísticas do monstro D&D 5e). Adicionar sistemas suportados aqui habilitará esses recursos.',
        'theme'                         => 'Force o tema da campanha, substituindo a preferência do usuário.',
        'view_public'                   => 'Para visualizar sua campanha como um visualizador público faria, abra :link em uma janela anônima.',
        'visibility'                    => 'Tornar uma campanha pública significa que qualquer pessoa com um link para ela poderá vê-la.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nova Campanha',
            ],
        ],
        'title'     => 'Campanhas',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Convidar',
            'copy'  => 'Copiar link para sua área de transferência',
            'link'  => 'Novo Link',
        ],
        'create'                => [
            'button'        => 'Convidar',
            'description'   => 'Convide um amigo para a sua campanha',
            'link'          => 'Link criado: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Convite enviado.',
            'title'         => 'Convide alguém para sua campanha',
        ],
        'destroy'               => [
            'success'   => 'Convite removido',
        ],
        'email'                 => [
            'link'      => '<a href=":link">Juntar-se a campanha de :name\'s </a>',
            'subject'   => ':name convidou você para juntar-se a sua campanha \':campaign\' no kanka.io! Use o link a seguir para aceitar o seu convite.',
            'title'     => 'Convite de :name',
        ],
        'error'                 => [
            'already_member'    => 'Você já é um membro dessa campanha.',
            'inactive_token'    => 'Esse token já foi utilizado, ou a campanha não existe mais.',
            'invalid_token'     => 'Esse token é inválido.',
            'login'             => 'Por favor entre ou cadastre-se para juntar-se a campanha.',
        ],
        'fields'                => [
            'created'   => 'Enviado',
            'email'     => 'Email',
            'role'      => 'Cargo',
            'type'      => 'Tipo',
            'validity'  => 'Validade',
        ],
        'helpers'               => [
            'email'     => 'Nossos e-mails são frequentemente sinalizados como spam e podem levar algumas horas antes de aparecerem na sua caixa de entrada.',
            'validity'  => 'Quantos usuários podem usar esse link antes que seja desativado.',
        ],
        'placeholders'          => [
            'email' => 'Email da pessoa que você deseja convidar',
        ],
        'types'                 => [
            'email' => 'Email',
            'link'  => 'Link',
        ],
        'unlimited_validity'    => 'Ilimitado',
    ],
    'leave'                             => [
        'confirm'   => 'Você tem certeza que deseja sair de :name campaign? Você não poderá acessar novamente, a não ser que o dono da campanha te convide novamente.',
        'error'     => 'Não foi possível sair da campanha.',
        'success'   => 'Você saiu da campanha.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Trocar',
            'switch-back'   => 'Voltar para meu usuário',
        ],
        'create'                => [
            'title' => 'Adicionar um membro a sua campanha',
        ],
        'description'           => 'Gerenciar os membros da campanha',
        'edit'                  => [
            'description'   => 'Edite um membro da sua campanha',
            'title'         => 'Editar membro :name',
        ],
        'fields'                => [
            'joined'        => 'Juntou-se em',
            'last_login'    => 'Último login',
            'name'          => 'Usuário',
            'role'          => 'Cargo',
            'roles'         => 'Cargos',
        ],
        'help'                  => 'Não há limite para o número de membros que uma campanha pode ter, e como Administrador da campanha, você pode remover membros que não estão mais ativos nela.',
        'helpers'               => [
            'admin' => 'Como membro com o cargo de administrador da campanha, você pode convidar novos usuários, remover os inativos e alterar suas permissões. Para testar as permissões de um membro, use o botão Alternar. Você pode ler mais sobre esse recurso no :link.',
            'switch'=> 'Trocar para este usuário',
        ],
        'impersonating'         => [
            'message'   => 'Você está vendo a campanha como outro usuário. Alguns recursos foram desabilitados, mas o resto age exatamente como o usuário veria. Para voltar ao seu usuário, use o botão Trocar de Volta localizado onde o botão Logout normalmente está localizado.',
            'title'     => 'Personificando :name',
        ],
        'invite'                => [
            'description'   => 'Você pode convidar amigos para se juntar a sua campanha fornecendo o endereço de email deles. Assim que eles aceitarem o convite, serão adicionados como um "Espectador". Você também pode cancelar o convite a qualquer momento.',
            'more'          => 'Você pode adicionar novos cargos em :link',
            'roles_page'    => 'Página de Cargos',
            'title'         => 'Convidar',
        ],
        'roles'                 => [
            'member'    => 'Membro',
            'owner'     => 'Dono',
            'player'    => 'Jogador',
            'public'    => 'Público',
            'viewer'    => 'Espectador',
        ],
        'switch_back_success'   => 'Você voltou para seu usuário original',
        'title'                 => 'Menbros da campanha :name',
        'your_role'             => 'Você é  <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Impulsionada',
        'dashboard' => 'Dashboard',
        'permission'=> 'Permissão',
        'sharing'   => 'Compartilhamento',
        'systems'   => 'Sistemas',
        'ui'        => 'Interface',
    ],
    'placeholders'                      => [
        'description'   => 'Um pequeno resumo da sua campanha',
        'locale'        => 'Idioma',
        'name'          => 'O nome da sua campanha',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Adicione um cargo',
        ],
        'create'        => [
            'success'   => 'Cargo criado',
            'title'     => 'Criar um novo cargo para :name',
        ],
        'description'   => 'Gerencie os cargos da campanha',
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
            'type'          => 'Tipo',
            'users'         => 'Usuários',
        ],
        'helper'        => [
            '1' => 'Uma campanha pode ter quantos cargos quiser. O cargo de "Administrador" tem automaticamente acesso a tudo de uma campanha, mas cada outro cargo pode ter permissões específicas em cada tipo de entidade (personagem, local, etc).',
            '2' => 'Entidades podem ter permissões mais refinadas visualizando a aba "Permissões" dessa entidade. Essa aba aparece uma vez que sua campanha tenha vários cargos ou membros.',
            '3' => 'Pode-se optar pelo sistema de "exclusão", onde o acesso para visualização de todas as entidades é dado aos cargos, e usar a caixa de seleção "Privado" nas entidades para escondê-las. Ou pode-se optar por não dar aos cargos muitas permissões, mas configurar cada entidade ser visível individualmente.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'A função pública tem permissões, mas a campanha é privada. Você pode alterar essa configuração na guia Compartilhamento ao editar a campanha.',
            'public'                => 'A função Pública é usada quando alguém navega em sua campanha pública. :more',
            'role_permissions'      => 'Habilitar o cargo \':name\' a fazer as seguintes ações em todas as entidades.',
        ],
        'members'       => 'Membros',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Criar',
                'delete'        => 'Deletar',
                'edit'          => 'Editar',
                'entity-note'   => 'Nota da entidade',
                'permission'    => 'Gerenciar Permissões',
                'read'          => 'Ver',
                'toggle'        => 'Mudar para todos',
            ],
            'helpers'   => [
                'entity_note'   => 'Isso permite que usuários que não têm permissões de edição em uma entidade adicionem notas de entidade a ela.',
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
        'title'         => 'Cargos da campanha :name',
        'types'         => [
            'owner'     => 'Adm',
            'public'    => 'Público',
            'standard'  => 'Padrão',
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
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Habilitar',
        ],
        'boosted'       => 'Este recurso está em acesso antecipado e atualmente disponível apenas para :boosted.',
        'description'   => 'Ativar ou desativar módulos da campanha',
        'edit'          => [
            'success'   => 'Configurações da campanha atualizadas.',
        ],
        'helper'        => 'Você pode facilmente desabilitar elementos da sua campanha que serão escondidos. Se você já havia criado elementos nas categorias que desabilitar, eles não serão deletados, apenas ocultados.',
        'helpers'       => [
            'abilities'     => 'Crie habilidades, sejam talentos, feitiços ou poderes que podem ser atribuídos a entidades.',
            'calendars'     => 'Um lugar para definir todos os calendários do seu mundo.',
            'categories'    => 'Cada entidade pode ter uma categoria. Categorias podem pertencer a outras categorias, e entidades podem ser filtradas por categorias.',
            'characters'    => 'O povo que habita seu mundo.',
            'conversations' => 'Conversas fictícias entre personagens ou entre usuários da campanha. Este módulo está obsoleto.',
            'dice_rolls'    => 'Para aqueles que usam Kanka para campanhas de RPG, uma maneira de cuidar das rolagens de dados.',
            'events'        => 'Feriados, festivais, desastres, aniversários, guerras.',
            'families'      => 'Clãs ou famílias, suas relações e seus membros.',
            'items'         => 'Armas, veículos, relíquias, poções.',
            'journals'      => 'Observações escritas por personagens, ou preparações de sessões para o mestre do jogo.',
            'locations'     => 'Planetas, planos, continentes, rios, estados, acampamentos, templos, tavernas.',
            'maps'          => 'Faça upload de mapas com camadas e marcadores apontando para outras entidades na campanha.',
            'menu_links'    => 'Links de menus personalizados na barra lateral.',
            'notes'         => 'História, religião, magia, raças.',
            'organisations' => 'Cultos, uniões militares, facções, guildas',
            'quests'        => 'Para manter controle de várias missões com personagens e locais.',
            'races'         => 'Se a sua campanha tiver mais de uma raça, isso tornará mais fácil manter o controle.',
            'tags'          => 'Cada entidade pode ter várias tags. As tags podem pertencer a outras tags e as entradas podem ser filtradas por tag.',
            'timelines'     => 'Represente a história do seu mundo com Linhas do Tempo.',
        ],
        'title'         => 'Módulos da campanha :name',
    ],
    'show'                              => [
        'actions'       => [
            'boost' => 'Impulsionar campanha.',
            'edit'  => 'Editar campanha',
            'leave' => 'Deixar campanha',
        ],
        'description'   => 'Uma visão detalhada da campanha',
        'tabs'          => [
            'default-images'    => 'Imagens Padrão',
            'export'            => 'Exportar',
            'information'       => 'Informações',
            'members'           => 'Membros',
            'menu'              => 'menu',
            'plugins'           => 'Plug-ins',
            'recovery'          => 'Recuperação',
            'roles'             => 'Cargos',
            'settings'          => 'Configurações',
        ],
        'title'         => 'Campanha :name',
    ],
    'ui'                                => [
        'helper'    => 'Use essas configurações para alterar a forma como alguns elementos serão exibidos na campanha.',
    ],
    'visibilities'                      => [
        'private'   => 'Privado',
        'public'    => 'Público',
        'review'    => 'Aguardando revisão',
    ],
];
