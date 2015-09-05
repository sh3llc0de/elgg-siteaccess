<?php

$plugin = elgg_get_plugin_from_id('siteaccess');

$params = get_input('params');
foreach ($params as $k => $v) {
	if (!$plugin->setSetting($k, $v)) {
		register_error(elgg_echo('plugins:settings:save:fail', array('siteaccess')));
		forward(REFERER);
	}
}

system_message(elgg_echo('siteaccess:settings:save:ok'));
forward(REFERER);
