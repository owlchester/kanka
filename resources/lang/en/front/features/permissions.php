<?php

return [
    'description'   => 'Permissions in Kanka can be fine tuned to control exactly what a user can and can\'t to. You can be as open or restrictive as you want, depending on your needs.',
    'fifth'         => 'Most entities have a "privacy" checkbox option which will supersede all other permissions. When checked, only members of the campaign\'s admin role will see the entity.',
    'first'         => 'Kanka\'s permissions is split into several concepts: role permissions and entity permissions. By default, each campaign comes with an Admin, a Public and a Player role. Members of the admin role can see and do everything in a campaign. The public role is used if the campaign is public and a user isn\'t part of it and by default the role has no permissions. Lastly, the player role also comes with no permissions by default, and is used for anyone who is part of the campaign. When you invite a new member to your campaign, you define what role they join as. You can create more roles, and move people around, as well as have members in several roles.',
    'fourth'        => 'To check the permissions of a user, go to your campaign\'s members page and click on the "View as" button. This button is only available to campaign admins, and can only be used on non campaign admins. When creating or editing an entity using this feature, the info will be saved in the entity\'s logs.',
    'second'        => 'A role can be set up in different ways. You can for example allow members of a role to view and create characters, but not edit or delete them. If a user can create an entity but can\'t modify it, they will automatically get update permissions.',
    'third'         => 'If you don\'t want to allow members of a role to see all characters, you can instead set permissions individually on each character, either by editing them or using the bulk permissions button visible to campaign admins on the list of characters. The same concepts apply for all other entity types.',
    'title'         => 'Permissions',
];
