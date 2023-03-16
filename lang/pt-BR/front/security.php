<?php

return [
    'communication' => [
        'description'   => 'Todos os dados do usuário são transportados de forma segura e privada, pois são criptografados em trânsito via SSL. A criptografia de dados em trânsito os protege contra espionagem não autorizada, modificação e ataques man-in-the-middle.',
        'title'         => 'Comunicação segura',
    ],
    'credit-card'   => [
        'description'   => 'Não armazenamos as informações do seu cartão de crédito. Usamos o Stripe para processar cartões de crédito, com todas as comunicações entre você, nossos servidores e o Stripe sendo criptografadas. As únicas informações de cartão de crédito fornecidas pela Stripe que armazenamos são a data de validade e a marca do seu cartão, para que possamos notificá-lo quando o seu cartão expirar.',
        'title'         => 'Cartões de crédito',
    ],
    'data-backup'   => [
        'description'   => 'Nosso banco de dados é copiado duas vezes por dia para garantir que seus dados permaneçam seguros e altamente disponíveis. Nossos backups de banco de dados são testados regularmente para garantir que possamos restaurar os dados rapidamente, se necessário.',
        'title'         => 'Backups de dados',
    ],
    'data-breach'   => [
        'description'   => 'Caso Kanka seja alvo de uma violação de dados envolvendo dados pessoais, iremos denunciá-la prontamente às autoridades locais, bem como aos usuários envolvidos.',
        'title'         => 'Violação de dados',
    ],
    'data-center'   => [
        'description'   => 'Kanka é hospedado em vários servidores para garantir a redundância, e temos procedimentos de recuperação de desastres caso algo ruim aconteça. Nossos servidores são hospedados pela Hetzner.',
        'title'         => 'Segurança do Data Center',
    ],
    'description'   => 'Nossa pequena equipe está empenhada em fornecer padrões de proteção de dados de alto nível para garantir que seus dados estejam seguros conosco.',
    'infrastructure'=> [
        'description'   => 'Nossos servidores e todos os seus dados estão hospedados em servidores dentro da União Europeia. Isso nos permite atender a requisitos regulamentares e de conformidade específicos que garantem que seus dados estejam seguros conosco. Nossos provedores de data center Hetzner e Amazon Cloud Europe têm um histórico de qualidade e experiência no manuseio de dados digitais.',
        'title'         => 'Infraestrutura hospedada na UE',
    ],
    'logs'          => [
        'description'   => 'Coletamos logs detalhados automaticamente para garantir que possamos resolver bugs e problemas com os usuários de maneira rápida e eficaz. Esses logs detalhados são excluídos com frequência e também são excluídos automaticamente quando você exclui sua conta.',
        'title'         => 'Coleção de logs',
    ],
    'title'         => 'Segurança em Kanka',
];
