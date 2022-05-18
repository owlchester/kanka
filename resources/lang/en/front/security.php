<?php

return [
    'title' => 'Security at :kanka',
    'description' => 'Our small team is commited to providing top notch data protection standards to ensure that your data is safe with us.',

    'data-center' => [
        'title' => 'Data center security',
        'description' => ':kanka is hosted on multiple servers to ensure redundency, and we have disaster recovery procedures in place should something bad happen. Our servers are hosted by Hetzner.',
    ],
    'infrastructure' => [
        'title' => 'EU hosted infrastructure',
        'description' => 'Our servers and all of your data is hosted on server inside the European Union. This allows us to meet specific regulatory and compliance requirements that ensure your data is safe with us. Our data center providers Hetzner and Amazon Cloud Europe have a history of quality and expertise in the handling of digital data.',
    ],
    'communication' => [
        'title' => 'Secure communication',
        'description' => 'All user data is transported securely and privately, as it is encrypted in transit via SSL. Encrypting data in transit protects it from unauthorised snooping, modification, as well as man-in-the-middle attacks.',
    ],
    'credit-card' => [
        'title' => 'Credit cards',
        'description' => 'We don\'t store your credit card information. We use Stripe to process credit cards, with all communication between you, our servers, and them being encrypted. The only credit card information provided from stripe that we store is your card\'s expiration date and brand, so that we can notify you when your card expires.',
    ],
    'data-backup' => [
        'title' => 'Data backups',
        'description' => 'Our database is backed up twice a day to ensure your data stays safe and highly available. Our database backups are regularily tested to ensure that we quickly restore data should it be needed.',
    ],
    'logs' => [
        'title' => 'Log collection',
        'description' => 'We automatically collect detailed logs to ensure that we can quickly and effectively resolve bugs and issues with users and their use of data. These detailed logs are frequently purged, and are also automatically purged when when you delete your account.',
    ],
    'data-breach' => [
        'title' => 'Data breach',
        'description' => 'Should :kanka be the target of a data breach involving personal data, we will promptly report to the local authority and to the users involved.',
    ],
];
