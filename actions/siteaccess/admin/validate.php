<?php

$guid = get_input('guid');
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);
$user = get_entity($guid);

if ($user instanceof ElggUser) {
    create_metadata($user->guid, 'admin_validated', true, '', 0, ACCESS_PUBLIC, false);
    system_message(elgg_echo('siteaccess:validate:user'));
}

access_show_hidden_entities($access_status);

forward(REFERRER);

