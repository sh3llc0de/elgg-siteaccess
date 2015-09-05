<?php

$plugin = elgg_get_plugin_from_id('siteaccess');

$title = elgg_echo('siteaccess:settings:main');
$content = elgg_view('forms/siteaccess/admin/settings/main', array('plugin' => $plugin));
echo elgg_view_module('inline', $title, $content);

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

