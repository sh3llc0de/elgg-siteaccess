<?php

$tab = get_input('tab', 'settings');

echo elgg_view('navigation/tabs', array(
	'tabs' => array(
		array(
			'text' => elgg_echo('settings'),
			'href' => 'admin/settings/siteaccess',
			'selected' => ($tab == 'settings'),
		),
#		array(
#			'text' => "test",
#			'href' => 'admin/settings/siteaccess?tab=test',
#			'selected' => ($tab == 'test'),
#		),
	    )
    ));

switch ($tab) {
    case 'test':
	echo elgg_view('admin/settings/siteaccess/test');
	break;

    case 'settings':
    default:
	echo elgg_view('admin/settings/siteaccess/settings');
	break;
}

