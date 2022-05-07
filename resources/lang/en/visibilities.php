<?php

return [
    'helpers'   => [
        'admin'         => 'Only members of the campaign\'s admin role will see this element.',
        'admin-self'    => 'A combination of the :admin and :self visibilities.',
        'all'           => 'Everyone can see this element.',
        'entities'      => 'In addition to the element\'s visibility value, if it is linked to an entity, the entity\'s permission will also come into play. For example, if a relation is visible to all, but the relation\'s target is only visible to admins, then only admins will see the relation.',
        'intro'         => 'Many elements in Kanka have a visibility option, allowing for a control on who sees what without having to set up complexe permissions.',
        'members'       => 'Only members of the campaign will see the element. Useful for a public campaign where members of it should see more than a public viewer.',
        'options'       => 'Here is a list of what each visibility does.',
        'self'          => 'Only the user who created the element will see it.',
        'title'         => 'Visibility',
    ],
    'tooltip'   => 'Click to learn about the various visibility options.',
];
