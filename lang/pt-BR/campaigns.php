<?php

return [
    'actions'                           => [],
    'create'                            => [
        'description'           => 'Criar uma nova campanha',
        'helper'                => [
            'title'     => 'Bem-vindo a :name!',
            'welcome'   => <<<'TEXT'
Antes de prosseguir, você precisa escolher um nome de campanha. Este é o nome do seu mundo. Se você ainda não tem um bom nome, não se preocupe, você sempre pode alterá-lo mais tarde ou criar mais campanhas.

Obrigado por se juntar a Kanka e bem-vindo à nossa crescente comunidade!
TEXT
,
        ],
        'success'               => 'Campanha criada.',
        'success_first_time'    => 'Sua campanha foi criada! Como é a sua primeira campanha, nós criamos algumas coisas para te ajudar e talvez lhe dar um pouco de inspiração no que você pode fazer.',
        'title'                 => 'Nova Campanha',
    ],
    'destroy'                           => [],
    'edit'                              => [
        'success'   => 'Campanha atualizada.',
        'title'     => 'Editar Campanha :campaign',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'Novos personagens tem sua personalidade privada por padrão.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Novas entidades são privadas.',
    ],
    'errors'                            => [
        'access'        => 'Você não tem acesso a esta campanha.',
        'premium'       => 'Esse recurso está disponível somente para campanhas premium.',
        'unknown_id'    => 'Campanha Desconhecida.',
    ],
    'export'                            => [],
    'fields'                            => [
        'boosted'                           => 'Impulsionada por',
        'character_personality_visibility'  => 'Visibilidade padrão da personalidade do personagem',
        'connections'                       => 'Mostra a tabela de conexão de uma entidade por padrão (ao invés do explorador de relação para campanhas impulsionadas)',
        'css'                               => 'CSS',
        'description'                       => 'Descrição',
        'entity_count'                      => 'Número de Entidades',
        'entity_privacy'                    => 'Privacidade padrão da nova entidade',
        'entry'                             => 'Descrição da campanha',
        'excerpt'                           => 'Texto do dashboard da campanha',
        'featured'                          => 'Campanha em destaque',
        'followers'                         => 'Seguidores',
        'gallery_visibility'                => 'Visibilidade Padrão da Imagem da Galeria',
        'genre'                             => 'Gênero(s)',
        'header_image'                      => 'Background do dashboard da campanha',
        'image'                             => 'Imagem da barra lateral',
        'is_discreet'                       => 'Discreta',
        'locale'                            => 'Local',
        'name'                              => 'Nome',
        'open'                              => 'Aberta a inscrições',
        'past_featured'                     => 'Campanha em destaque anteriormente',
        'post_collapsed'                    => 'Novos posts nas entidades são recolhidas por padrão.',
        'premium'                           => 'Premium desbloqueado por :name',
        'public'                            => 'Visibilidade da campanha',
        'public_campaign_filters'           => 'Filtros de Campanhas Públicas',
        'related_visibility'                => 'Visibilidade dos Elementos Relacionados',
        'superboosted'                      => 'Super-impulsionada por',
        'system'                            => 'Sistema',
        'theme'                             => 'Tema',
        'vanity'                            => 'URL personalizada',
        'visibility'                        => 'Visibilidade',
    ],
    'following'                         => 'Seguindo',
    'helpers'                           => [
        'boosted'                           => 'Alguns recursos requerem que a campanha esteja sendo impulsionada. Mais informações na página :settings.',
        'character_personality_visibility'  => 'Ao criar um novo personagem como administrador, selecione a configuração de privacidade padrão para seus traços de personalidade.',
        'css'                               => 'Escreva seu próprio CSS que será carregado nas páginas de sua campanha. Observe que qualquer abuso desse recurso pode levar à remoção do seu CSS personalizado. Ofensas repetidas ou graves podem levar à remoção de sua campanha.',
        'dashboard'                         => 'Personalize a forma como o widget do dashboard da campanha é exibido preenchendo os campos a seguir.',
        'entity_count_v3'                   => 'Este número é recalculado a cada :amount horas.',
        'entity_privacy'                    => 'Ao criar uma nova entidade como administrador, selecione a configuração de privacidade padrão da nova entidade.',
        'excerpt'                           => 'O resumo da campanha será exibido no painel, então escreva algumas frases apresentando o seu mundo. Mantenha-o curto para obter os melhores resultados.',
        'gallery_visibility'                => 'Valor da Visibilidade Padrão ao enviar imagens para a galeria.',
        'header_image'                      => 'Imagem exibida como plano de fundo no widget cabeçalho da campanha do dashboard.',
        'hide_history'                      => 'Habilite esta opção para ocultar o histórico de entidades para membros não administradores da campanha.',
        'hide_members'                      => 'Habilite esta opção para ocultar a lista de membros da campanha para membros não administradores.',
        'is_discreet'                       => 'Se ativado quando a campanha for pública, ela não será exibida em :public-campaigns.',
        'is_discreet_locked'                => 'As campanhas Premium podem ser configuradas para serem visíveis publicamente, mas não aparecerem nas :public-campaigns.',
        'locale'                            => 'O idioma em que sua campanha está escrita. É usado para gerar conteúdo e agrupar campanhas públicas.',
        'name'                              => 'Sua campanha/mundo pode ter qualquer nome, desde que contenha pelo menos 4 letras ou números.',
        'no_entry'                          => 'Parece que a campanha ainda não tem descrição! Vamos consertar isso.',
        'permissions_tab'                   => 'Controle as configurações padrão de privacidade e visibilidade de novos elementos com as seguintes opções.',
        'premium'                           => 'Alguns recursos estão disponíveis porque os recursos premium desta campanha estão desbloqueados. Saiba mais na página :settings.',
        'public_campaign_filters'           => 'Ajude outras pessoas a encontrar a campanha entre outras campanhas públicas, fornecendo as seguintes informações.',
        'public_no_visibility'              => 'Atenção! Sua campanha é pública, mas a função pública da campanha não pode acessar nada. :fix.',
        'related_visibility'                => 'Visibilidade padrão ao criar um novo elemento com este campo (posts, relações, habilidades, etc)',
        'system'                            => 'Se a sua campanha estiver publicamente visível, o sistema será mostrado na página :link.',
        'systems'                           => 'Para evitar sobrecarregar os usuários com opções, alguns recursos do Kanka estão disponíveis apenas com sistemas de RPG específicos (ou seja, o bloco de estatísticas do monstro D&D 5e). Adicionar sistemas suportados aqui habilitará esses recursos.',
        'theme'                             => 'Force o tema da campanha, substituindo a preferência do usuário.',
        'view_public'                       => 'Para visualizar sua campanha como um visualizador público faria, abra :link em uma janela anônima.',
        'visibility'                        => 'Tornar uma campanha pública significa que qualquer pessoa com um link para ela poderá vê-la.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nova Campanha',
            ],
        ],
    ],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'Copiar link para sua área de transferência',
            'link'  => 'Convidar pessoas',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Gerar link',
            ],
            'success_link'  => 'Link criado: :link',
            'title'         => 'Convide amigos para :campaign',
        ],
        'destroy'               => [
            'success'   => 'Convite removido.',
        ],
        'error'                 => [
            'already_member'    => 'Você já é um membro dessa campanha.',
            'inactive_token'    => 'Esse token já foi utilizado, ou a campanha não existe mais.',
            'invalid_token'     => 'Esse token não é mais válido.',
            'join'              => 'Faça login ou registre uma nova conta para participar da :campaign.',
            'login'             => 'Por favor entre ou cadastre-se para juntar-se a campanha.',
        ],
        'fields'                => [
            'created'   => 'Criado',
            'role'      => 'Cargo',
            'token'     => 'Token',
            'type'      => 'Tipo',
            'usage'     => 'Expira depois de',
        ],
        'unlimited_validity'    => 'Ilimitado',
        'usages'                => [
            'five'      => '5 usos',
            'no_limit'  => 'Nunca',
            'once'      => '1 uso',
            'ten'       => '10 usos',
        ],
    ],
    'leave'                             => [
        'confirm'           => 'Você tem certeza que deseja sair da campanha :name? Você não poderá acessá-la novamente, a não ser que o dono da campanha te convide novamente.',
        'confirm-button'    => 'Sim, sair da campanha',
        'error'             => 'Não foi possível sair da campanha.',
        'fix'               => 'Acesse os membros da campanha',
        'no-admin-left'     => 'Não é possível sair da campanha porque isso a deixaria sem nenhum administrador. Adicione primeiro outro membro ao cargo de administrador.',
        'success'           => 'Você saiu da campanha.',
        'title'             => 'Saindo da campanha',
    ],
    'members'                           => [
        'actions'               => [
            'remove'        => 'Remover da campanha',
            'switch'        => 'Visualizar campanha como usuário',
            'switch-back'   => 'Voltar para meu usuário',
            'switch-entity' => 'Visualizar como',
        ],
        'create'                => [
            'title' => 'Adicionar um membro a sua campanha',
        ],
        'edit'                  => [
            'title' => 'Editar membro :name',
        ],
        'fields'                => [
            'banned'        => 'Usuário está banido',
            'joined'        => 'Juntou-se em',
            'last_login'    => 'Último login',
            'name'          => 'Usuário',
            'role'          => 'Cargo',
            'roles'         => 'Cargos',
        ],
        'helpers'               => [
            'switch'    => 'Trocar para este usuário',
        ],
        'impersonating'         => [
            'message'   => 'Você está vendo a campanha como outro usuário. Alguns recursos foram desabilitados, mas o resto age exatamente como o usuário veria. Para voltar ao seu usuário, use o botão Trocar de Volta localizado onde o botão Logout normalmente está localizado.',
            'title'     => 'Personificando :name',
        ],
        'invite'                => [
            'description'   => 'Você pode convidar amigos para se juntar a sua campanha fornecendo o endereço de email deles. Assim que eles aceitarem o convite, serão adicionados como um "Espectador". Você também pode cancelar o convite a qualquer momento.',
            'more'          => 'Você pode adicionar novos cargos em :link',
            'title'         => 'Convidar',
        ],
        'manage_roles'          => 'Gerenciar funções de usuário',
        'removal'               => 'Você está removendo ":member" da campanha.',
        'roles'                 => [
            'member'    => 'Membro',
            'owner'     => 'Administrador',
            'player'    => 'Jogador',
            'public'    => 'Público',
            'viewer'    => 'Espectador',
        ],
        'switch_back_success'   => 'Você voltou para sua conta.',
        'title'                 => 'Menbros - :name',
        'updates'               => [
            'added'     => 'Cargo :role adicionado ao :user.',
            'removed'   => 'Cargo :role removido do :user.',
        ],
    ],
    'modules'                           => [
        'permission-disabled'   => 'Este módulo está desativado.',
    ],
    'open_campaign'                     => [],
    'options'                           => [],
    'overview'                          => [
        'entity-count'      => '{0} Nenhuma entidade|{1} :amount entidade|[2,*] :amount entidades',
        'follower-count'    => '{0} Nenhum seguidor|{1} :amount seguidor|[2,*] :amount seguidores',
    ],
    'panels'                            => [
        'dashboard' => 'Dashboard',
        'permission'=> 'Permissão',
        'setup'     => 'Configuração',
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
    'privacy'                           => [
        'hidden'    => 'Escondido',
        'private'   => 'Privado',
        'visible'   => 'Visível',
    ],
    'public'                            => [
        'helpers'   => [
            'introduction'  => 'As campanhas são privadas por padrão e podem ser tornadas públicas. Isso permite que qualquer pessoa as acesse, e as torna disponíveis na página :public-campaigns se elas tiverem entidades visíveis para a função :public-role. Uma campanha pública é visível para todos, mas para que seu conteúdo seja visível, a função :public-role precisa de permissões adequadas.',
        ],
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Criar cargo',
            'duplicate'     => 'Duplicar cargo',
            'permissions'   => 'Gerenciar permissões',
            'rename'        => 'Renomear função',
            'save'          => 'Salvar função',
        ],
        'admin_role'    => 'cargo de administrador',
        'bulks'         => [
            'delete'    => '{1} Removido :count cargo.|[2,*] Removidos :count cargos.',
            'edit'      => '{1} Atualizado :count cargo.|[2,*] Atualizados :count cargos.',
        ],
        'create'        => [
            'success'   => 'Cargo :name criado.',
            'title'     => 'Novo cargo',
        ],
        'destroy'       => [
            'success'   => 'Cargo :name removido.',
        ],
        'edit'          => [
            'success'   => 'Cargo :name atualizado.',
            'title'     => 'Editar cargo :name',
        ],
        'fields'        => [
            'copy_permissions'  => 'Copiar permissões',
            'name'              => 'Nome',
            'permissions'       => 'Permissões',
            'type'              => 'Tipo',
            'users'             => 'Usuários',
        ],
        'helper'        => [
            '1'                     => 'Uma campanha pode ter quantos cargos quiser. O cargo de "Administrador" tem automaticamente acesso a tudo de uma campanha, mas cada outro cargo pode ter permissões específicas em cada tipo de entidade (personagem, local, etc).',
            '2'                     => 'Entidades podem ter permissões mais refinadas visualizando a aba "Permissões" dessa entidade. Essa aba aparece uma vez que sua campanha tenha vários cargos ou membros.',
            '3'                     => 'Pode-se optar pelo sistema de "exclusão", onde o acesso para visualização de todas as entidades é dado aos cargos, e usar a caixa de seleção "Privado" nas entidades para escondê-las. Ou pode-se optar por não dar aos cargos muitas permissões, mas configurar cada entidade ser visível individualmente.',
            '4'                     => 'Campanhas impulsionadas podem ter uma quantidade ilimitada de cargos.',
            'permissions_helper'    => 'Duplique todas as permissões do cargo, tanto nos módulos quanto nas entidades.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'A função pública tem permissões, mas a campanha é privada. Você pode alterar essa configuração na guia Compartilhamento ao editar a campanha.',
            'empty_role'            => 'A função ainda não tem membros.',
            'role_admin'            => 'A função :name concede automaticamente acesso a tudo na campanha para seus membros.',
            'role_permissions'      => 'Habilitar o cargo \':name\' a fazer as seguintes ações em todas as entidades.',
        ],
        'members'       => 'Membros',
        'modals'        => [
            'details'   => [
                'campaign'  => 'As permissões da campanha permitem o seguinte:',
                'entities'  => 'Aqui está uma rápida recapitulação do que os membros dessa função obtêm quando uma permissão é definida.',
                'more'      => 'Para mais detalhes, veja nosso vídeo tutorial no Youtube',
                'title'     => 'Detalhes da permissão',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Criar',
                'dashboard'     => 'Dashboard',
                'delete'        => 'Deletar',
                'edit'          => 'Editar',
                'entity-note'   => 'Post',
                'gallery'       => [
                    'browse'    => 'Navegar',
                    'manage'    => 'Controle total',
                    'upload'    => 'Carregar',
                ],
                'manage'        => 'Gerenciar',
                'members'       => 'Membros',
                'permission'    => 'Permissões',
                'read'          => 'Ver',
                'toggle'        => 'Mudar para todos',
            ],
            'helpers'   => [
                'add'           => 'Permitir a criação de entidades deste tipo. Eles terão permissão automática para visualizar e editar as entidades que criarem, se não tiverem permissão para visualizar ou editar.',
                'dashboard'     => 'Permitir editar os dashboards e os widgets dos dashboards.',
                'delete'        => 'Permitir remover todas as entidades desse tipo.',
                'edit'          => 'Permitir editar todas as entidades desse tipo.',
                'entity_note'   => 'Isso permite que usuários que não têm permissões de edição em uma entidade adicionem posts a ela.',
                'gallery'       => [
                    'browse'    => 'Permitir visualizar a galeria e definir a imagem de uma entidade da galeria.',
                    'manage'    => 'Permita tudo na galeria que um administrador pode, incluindo edição e exclusão de imagens.',
                    'upload'    => 'Permite fazer upload de imagens para a galeria. Só verão as imagens que enviaram se não forem combinadas com a permissão de navegar.',
                ],
                'manage'        => 'Permitir a edição da campanha como um administrador de campanha faria, sem permitir que os membros excluam a campanha.',
                'members'       => 'Permitir convidar novos membros para a campanha.',
                'not_public'    => 'A campanha não é pública. Permissões para a função pública podem ser definidas, mas serão ignoradas. Vá e edite a campanha para torná-la pública.',
                'permission'    => 'Permitir a configuração de permissões em entidades desse tipo que eles podem editar.',
                'read'          => 'Permitir a visualização de todas as entidades deste tipo que não sejam privadas.',
            ],
        ],
        'placeholders'  => [
            'name'  => 'Nome do cargo',
        ],
        'show'          => [
            'title' => 'Cargo de Campanha \':role\'',
        ],
        'title'         => 'Cargos - :name',
        'types'         => [
            'owner'     => 'Administrador',
            'public'    => 'Público',
            'standard'  => 'Padrão',
        ],
        'users'         => [
            'actions'   => [
                'add'           => 'Adicionar membro',
                'remove'        => ':user do cargo :role',
                'remove_user'   => 'Remover usuário do cargo',
            ],
            'create'    => [
                'success'   => 'Usuário adicionado ao cargo :role',
                'title'     => 'Adicione um membro para o cargo :name',
            ],
            'destroy'   => [
                'success'   => 'Usuário removido do cargo :role.',
            ],
            'errors'    => [
                'cant_kick_admins'  => 'Para evitar abusos, não é possível remover outros membros do cargo de :admin da campanha. Em caso de problemas, entre em contato conosco no :discord ou no :email.',
                'needs_more_roles'  => 'Você precisa se adicionar a outro cargo na campanha antes de poder se remover do cargo :admin.',
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
        'deprecated'    => [
            'help'  => 'Este módulo está obsoleto, o que significa que não é mais mantido e que os bugs não são testados a cada nova atualização. Use este módulo com o conhecimento de que ele será removido do Kanka.',
            'title' => 'Descontinuado',
        ],
        'disabled'      => 'O módulo :module está desabilitado.',
        'enabled'       => 'O módulo :module está habilitado.',
        'errors'        => [
            'module-disabled'   => 'O módulo solicitado está atualmente desabilitado nas configurações da campanha. :fix.',
        ],
        'helpers'       => [
            'abilities'         => 'Crie habilidades, sejam talentos, feitiços ou poderes que podem ser atribuídos a entidades.',
            'assets'            => 'Carregue arquivos, defina links e defina pseudônimos para entidades individuais.',
            'bookmarks'         => 'Crie marcadores para entidades ou listas filtradas que aparecem na barra lateral.',
            'calendars'         => 'Um lugar para definir todos os calendários do seu mundo.',
            'characters'        => 'O povo que habita seu mundo.',
            'conversations'     => 'Conversas fictícias entre personagens ou entre usuários da campanha. Este módulo está obsoleto.',
            'creatures'         => 'Construa as criaturas, animais e monstros do seu mundo com o módulo de criaturas.',
            'dice_rolls'        => 'Para aqueles que usam Kanka para campanhas de RPG, uma maneira de cuidar das rolagens de dados.',
            'entity_attributes' => 'Acompanhe os atributos nas entidades da campanha, por exemplo, PVs ou DESLOCAMENTO.',
            'events'            => 'Feriados, festivais, desastres, aniversários, guerras.',
            'families'          => 'Clãs ou famílias, suas relações e seus membros.',
            'inventories'       => 'Gerenciar inventários em suas entidades.',
            'items'             => 'Armas, veículos, relíquias, poções.',
            'journals'          => 'Observações escritas por personagens, ou preparações de sessões para o mestre do jogo.',
            'locations'         => 'Planetas, planos, continentes, rios, estados, acampamentos, templos, tavernas.',
            'maps'              => 'Faça upload de mapas com camadas e marcadores apontando para outras entidades na campanha.',
            'notes'             => 'Conhecimento, natureza, história, magia, culturas.',
            'organisations'     => 'Cultos, religiões, facções, guildas.',
            'quests'            => 'Para manter controle de várias missões com personagens e locais.',
            'races'             => 'Se a sua campanha tiver mais de uma raça, isso tornará mais fácil manter o controle.',
            'tags'              => 'Cada entidade pode ter várias tags. As tags podem pertencer a outras tags e as entradas podem ser filtradas por tag.',
            'timelines'         => 'Represente a história do seu mundo com Linhas do Tempo.',
        ],
    ],
    'sharing'                           => [
        'filters'   => 'As campanhas públicas são visíveis na página :public-campaigns. O preenchimento desses campos facilita a descoberta da campanha.',
        'language'  => 'O idioma no qual o conteúdo da campanha está escrito.',
        'system'    => 'Se estiver jogando um TTRPG, o sistema usado para jogar na campanha.',
    ],
    'show'                              => [
        'actions'   => [
            'edit'  => 'Editar campanha',
            'leave' => 'Sair da campanha',
        ],
        'menus'     => [
            'configuration'     => 'Configuração',
            'overview'          => 'Visão Geral',
            'user_management'   => 'Gerenciar usuários',
        ],
        'tabs'      => [
            'achievements'      => 'Conquistas',
            'applications'      => 'Solicitações',
            'campaign'          => 'Campanha',
            'customisation'     => 'Personalização',
            'data'              => 'Dados',
            'default-images'    => 'Imagens de miniatura padrão',
            'export'            => 'Exportar',
            'import'            => 'Importar',
            'information'       => 'Informações',
            'management'        => 'Gerenciamento',
            'members'           => 'Membros',
            'modules'           => 'Módulos',
            'plugins'           => 'Plugins',
            'recovery'          => 'Restaurar',
            'roles'             => 'Cargos',
            'sidebar'           => 'Configurar barra lateral',
            'styles'            => 'Temas',
            'webhooks'          => 'Webhooks',
        ],
        'title'     => 'Visão Geral - :name',
    ],
    'superboosted'                      => [],
    'themes'                            => [
        'none'  => 'Nenhum (padrão para configurações do usuário)',
    ],
    'ui'                                => [
        'collapsed'         => [
            'collapsed' => 'Recolhido',
            'default'   => 'Padrão',
        ],
        'connections'       => [
            'explorer'  => 'Explorador de relações (se disponível, para campanhas impulsionadas)',
            'list'      => 'Interface da lista',
        ],
        'entity_history'    => [
            'hidden'    => 'Apenas visível aos administradores da campanha.',
            'visible'   => 'Visível aos membros',
        ],
        'fields'            => [
            'connections'       => 'Interface padrão das conexões da entidade',
            'connections_mode'  => 'Modo explorador de relações padrão',
            'entity_history'    => 'Registro de histórico da entidade',
            'entity_image'      => 'Imagem da entidade',
            'member_list'       => 'Lista de membros da campanha',
            'post_collapsed'    => 'Valor padrão do campo recolhido de um novo post',
        ],
        'helpers'           => [
            'connections'       => 'Ao clicar na subpágina de conexões de uma entidade, selecione a interface padrão mostrada.',
            'connections_mode'  => 'Ao visualizar o gerenciador de relações de uma entidade, defina o modo padrão selecionado.',
            'entity-history'    => 'Controle quem pode ver as alterações recentes feitas em entidades individuais da campanha.',
            'member-list'       => 'Controle quem pode ver quem está na campanha.',
            'other'             => 'Outras opções visuais para a campanha.',
            'post_collapsed'    => 'Ao criar um novo post em uma entidade, selecione o valor padrão do campo recolhido.',
            'theme'             => 'Exiba a campanha no tema do usuário ou force-a a renderizar em um dos seguintes temas.',
            'tooltip'           => 'Controle quais informações ficam visíveis ao passar o mouse sobre o nome de uma entidade em sua dica de contexto.',
        ],
        'members'           => [
            'hidden'    => 'Apenas visível aos administradores da campanha',
            'visible'   => 'Visível aos membros',
        ],
        'other'             => 'Outro',
    ],
    'visibilities'                      => [
        'private'   => 'Campanha privada',
        'public'    => 'Campanha pública',
        'review'    => 'Aguardando Revisão',
    ],
    'warning'                           => [],
];
