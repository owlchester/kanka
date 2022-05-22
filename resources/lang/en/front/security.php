<?php

return [
    'communication' => [
        'description'   => 'All user data is transported securely and privately, as it is encrypted in transit via SSL. Encrypting data in transit protects it from unauthorised snooping, modification, as well as man-in-the-middle attacks.',
        'title'         => 'Secure communication',
    ],
    'credit-card'   => [
        'description'   => 'We don\'t store your credit card information. We use Stripe to process credit cards, with all communication between you, our servers, and Stripe being encrypted. The only credit card information provided by Stripe that we store is your card\'s expiration date and brand, so that we can notify you when your card expires.',
        'title'         => 'Credit cards',
    ],
    'data-backup'   => [
        'description'   => 'Our database is backed up twice a day to ensure your data stays safe and highly available. Our database backups are regularly tested to ensure that we can quickly restore data if needed.',
        'title'         => 'Data backups',
    ],
    'data-breach'   => [
        'description'   => 'Should Kanka be the target of a data breach involving personal data, we will promptly report it to the local authorities as well as to the users involved.',
        'title'         => 'Data breach',
    ],
    'data-center'   => [
        'description'   => 'Kanka is hosted on multiple servers to ensure redundancy, and we have disaster recovery procedures in place should something bad happen. Our servers are hosted by Hetzner.',
        'title'         => 'Data centre security',
    ],
    'description'   => 'Our small team is commited to providing top notch data protection standards to ensure that your data is safe with us.',
    'infrastructure'=> [
        'description'   => 'Our servers and all of your data is hosted on servers inside the European Union. This allows us to meet specific regulatory and compliance requirements that ensure your data is safe with us. Our data center providers Hetzner and Amazon Cloud Europe have a history of quality and expertise in the handling of digital data.',
        'title'         => 'EU hosted infrastructure',
    ],
    'logs'          => [
        'description'   => 'We automatically collect detailed logs to ensure that we can quickly and effectively resolve bugs and issues with users. These detailed logs are frequently purged, and are also automatically purged when when you delete your account.',
        'title'         => 'Log collection',
    ],
    'title'         => 'Security at Kanka',
];
