<?php

return [
    'app_backup'            => [
        'answer'    => 'Fazemos dois backups por dia para evitar qualquer perda de dados. Nossas próprias campanhas estão no servidor, então não queremos correr riscos!',
        'question'  => 'Com que frequência é feito backup dos dados em Kanka?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
A melhor maneira de explicar os Modelos de Atributo é com um exemplo. Vamos imaginar que seu mundo tem muitos locais e, em muitos desses locais, você deseja se lembrar de criar um atributo personalizado para "População", "Clima", "Nível de crime".

Agora, você poderia fazer isso facilmente em todos os locais, mas pode se tornar tedioso e às vezes você pode se esquecer de criar o atributo "Nível de crime". É aqui que os Modelos de Atributo entram em jogo.

Você pode criar um Modelo de Atributo com esses atributos (População, Clima, Nível de Crime, etc) e, posteriormente, aplicar esse modelo às suas localizações. Isso criará os atributos do modelo nos locais, então tudo que você precisa fazer é alterar os valores e não precisa se lembrar dos atributos!
TEXT
,
        'question'  => 'Modelos de Atributo, o que são eles?',
    ],
    'backup'                => [
        'answer'    => 'Uma vez por dia, você pode exportar todos os dados de sua campanha como um arquivo ZIP. No aplicativo, clique em "Campanha" no menu à esquerda e clique em "Exportar". Isso criará uma exportação que ficará disponível por 30 minutos. Você não pode fazer upload desta exportação para Kanka; ela é destinada apenas para sua própria tranquilidade ou se você não planeja mais usar o aplicativo.',
        'question'  => 'Como posso fazer backup ou exportar minha campanha?',
    ],
    'bugs'                  => [
        'answer'    => 'Basta entrar em nosso servidor do :discord e relatar seu bug no canal #error-and-bugs.',
        'question'  => 'Como posso relatar um bug?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka não tem esse recurso. No entanto, se você está tentando ter vários grupos de jogo no mesmo mundo, considere usar a mesma campanha e separar seus grupos por meio de uma combinação de missões, tags e permissões',
        'question'  => 'Posso sincronizar entidades em várias campanhas?',
    ],
    'conversations'         => [
        'answer'    => 'As Conversas podem ser configuradas como conversas entre personagens ou entre membros da campanha. Se, por exemplo, você deseja documentar uma conversa importante entre NPCs e os Personagens dos Jogadores, pode fazê-lo usando este módulo. Você também pode usá-los para campanhas feitas por posts.',
        'question'  => 'O que são Conversas?',
    ],
    'custom'                => [
        'answer'    => 'Kanka vem com um conjunto de tipos de entidades predefinidas que interagem entre si. Permitir tipos de entidade personalizados exigiria reconstruir o aplicativo do zero e anular o propósito de uma ferramenta com tipos predefinidos para ajudar as pessoas a construir um mundo em vez de descobrir como organizar as coisas. Além disso, Kanka é flexível com tags que podem representar a maioria dos cenários de tipo de entidade personalizado.',
        'question'  => 'Posso criar tipos de entidade personalizados?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Vá para o painel de sua campanha e clique em "Campanha" no menu à esquerda. Um botão "Excluir" campanha aparecerá se você for o último membro da campanha. Excluir uma campanha é uma ação permanente que irá excluir todos os dados armazenados em nossos servidores, incluindo imagens.',
        'question'  => 'Como posso deletar uma campanha?',
    ],
    'early-access'          => [
        'answer'    => 'O Acesso Antecipado é uma forma de recompensar nossos incríveis assinantes, dando-lhes um período exclusivo de 30 dias, onde podem experimentar os módulos mais recentes antes de qualquer outra pessoa.',
        'question'  => 'O que é Acesso Antecipado?',
    ],
    'entity-notes'          => [
        'answer'    => 'Todas as entidades têm uma guia \'Notas de Entidade\' que são pequenos trechos de texto que podem ser configurados para serem visíveis apenas por você (ótimo para campanhas com mais de um Mestre), apenas para membros da com o cargo de administrador ou visíveis para todos. Você também pode dar a seus jogadores permissão para criar e editar notas de entidade em entidades sem ter que permitir que eles editem uma entidade inteira.',
        'question'  => 'Como Kanka lida com informações parcialmente ocultas?',
    ],
    'fields'                => [
        'answer'    => 'Resposta',
        'category'  => 'Categoria',
        'locale'    => 'Localidade',
        'order'     => 'Ordem',
        'question'  => 'Questão',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Sim! Acreditamos fortemente que sua situação financeira não deve afetar sua diversão com RPGs ou construção de mundos e sempre manteremos o aplicativo principal gratuito. No entanto, se você deseja ter um papel mais ativo nesta jornada, nos apoiar e votar nos recursos que mais lhe importam, você pode fazê-lo por meio de nossas assinaturas.

Além de votar na direção que Kanka toma, nos apoiar permite que você ganhe acesso a :boosters, aumentar o limite do tamanho de  upload de arquivos, adicionar seu nome ao Hall da Fama, ter ícones padrão mais legais e muito mais!
TEXT
,
        'question'  => 'O aplicativo vai continuar sendo gratuito?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Recomendamos a criação de Deuses como Personagens e a criação de religiões como Organizações. Se você deseja encontrar rapidamente suas divindades, recomendamos marcá-las com uma tag e/ou tipo apropriado.',
        'question'  => 'Onde criar Deuses e Religiões?',
    ],
    'help'                  => [
        'answer'    => 'Em primeiro lugar, obrigado por querer ajudar! Estamos sempre interessados em pessoas que possam ajudar com traduções, que possam testar novos recursos ou que possam ajudar novos usuários. Também adoramos quando as pessoas promovem o Kanka para alcançar novos usuários em lugares que não tínhamos pensado. Seu melhor curso de ação é juntar-se a nós no :discord, onde há um canal dedicado a ajudar.',
        'question'  => 'Como posso ajudar?',
    ],
    'map'                   => [
        'answer'    => 'O módulo de Mapas suporta imagens PNG, JPG e SVG. Esses mapas podem ter camadas, grupos e marcadores apontando de várias formas e tamanhos que apontam para outras entidades em uma campanha.',
        'question'  => 'Posso fazer upload de mapas no Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Atualmente, não há um aplicativo para celular do Kanka, mas a maior parte do aplicativo funciona em um dispositivo móvel. Esperamos que o suporte por meio de assinaturas nos permita pagar alguém para construir um aplicativo móvel um dia, mas não prevemos isso no futuro próximo.',
        'question'  => 'Há um aplicativo para celular? Há algum planejado?',
    ],
    'monsters'              => [
        'answer'    => 'Recomendamos usar o módulo Raças para povos, espécies, monstros e qualquer coisa viva que não seja um personagem.',
        'question'  => 'Onde criar monstros?',
    ],
    'multiworld'            => [
        'answer'    => 'Você pode fazer parte de quantas campanhas quiser, incluindo as que criou. Para mudar ou criar uma nova campanha, vá para o painel de sua campanha e no canto superior direito você pode clicar em sua campanha atual para exibir a interface do alternador de campanha.',
        'question'  => 'Posso ter mais de uma campanha?',
    ],
    'nested'                => [
        'answer'    => 'Se você preferir visualizar suas entidades em uma visualização aninhada por padrão (por exemplo, o botão Visualização aninhada na lista de locais), você pode fazer isso acessando as opções de Perfil e Layout. Lá você pode marcar a opção Visualização aninhada. Isso é apenas para sua conta e não para suas campanhas.',
        'question'  => 'Posso definir as listas a serem aninhadas por padrão?',
    ],
    'organise_play'         => [
        'answer'    => 'Fizemos parceria com :lfgm que permite que você organize suas sessões com seu grupo. Você pode sincronizar sua campanha Kanka com sua campanha LFGM para mostrar suas próximas disponibilidades diretamente no painel da campanha.',
        'question'  => 'Como posso gerenciar quando minhas sessões acontecem?',
    ],
    'permissions'           => [
        'answer'    => 'Com certeza, é por isso que construímos o Kanka! Você pode convidar todos os seus jogadores para suas campanhas e dar-lhes funções e permissões. Construímos o sistema para ser extremamente flexível (você pode usar uma configuração opt-in e opt-out) para cobrir o máximo de necessidades e situações possíveis.',
        'question'  => 'Posso limitar as informações que meus jogadores veem em minha campanha?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
O plano de longo prazo para Kanka é construir uma ferramenta versátil de construção de mundos e gerenciamento de campanha que seja independente do sistema com conteúdo gerenciado pela comunidade na forma de "Modelos de Comunidade". Outro objetivo nosso é construir ferramentas que se integrem com outras plataformas, como aplicativos de mesa virtuais.

Nós mesmos usamos o Kanka, então temos o plano de jamais parar de desenvolvê-lo e aprimorá-lo. No entanto, apenas por segurança, o projeto também é de código aberto e pode ser continuado pela comunidade se algo acontecer conosco.
TEXT
,
        'question'  => 'Quais são os planos de longo prazo?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Você pode navegar na página :public-campaigns para ver como outras pessoas usam o Kanka em suas campanhas.',
        'question'  => 'Como outras pessoas usam o Kanka?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Embora isso seja fácil de fazer para o inglês e outros idiomas que não usam nomes de gênero, ser capaz de alterar o nome dos módulos quebraria a correção gramatical e a experiência do usuário para a maioria dos idiomas em que o Kanka também está disponível.',
        'question'  => 'Posso renomear módulos? Por exemplo, famílias para clãs ou organizações para facções?',
    ],
    'sections'              => [
        'community'     => 'Comunidade',
        'general'       => 'Geral',
        'other'         => 'Outros',
        'permissions'   => 'Permissões',
        'pricing'       => 'preços',
        'worldbuilding' => 'Construção de Mundo',
    ],
    'show'                  => [
        'return'    => 'Voltar pas Perguntas Frequentes',
        'timestamp' => 'Atualizado pela última vez em :date',
        'title'     => 'Perguntas Frequentes :name',
    ],
    'user-switch'           => [
        'answer'    => 'As permissões podem ser complicadas, especialmente com grandes campanhas. Como administrador da campanha, você pode navegar até a página dos membros da campanha e clicar no botão "Alternar" que aparecerá ao lado dos membros não administradores da campanha. Isso fará com que você se conecte como esse usuário e permitirá que você veja a campanha como eles o veriam. Esta é a maneira mais fácil de verificar as permissões de sua campanha.',
        'question'  => 'Minhas permissões de campanha estão configuradas, como posso testá-las?',
    ],
    'visibility'            => [
        'answer'    => 'Apenas as pessoas que você convida para sua campanha podem ver e interagir com o que você criou. Seus dados são privados e sempre sob seu controle. Você também pode definir sua campanha como pública para permitir que usuários não registrados a visualizem.',
        'question'  => 'Alguém pode ver meu mundo?',
    ],
];
