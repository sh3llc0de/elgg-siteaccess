<?php

$user = $vars['entity'];
$ts = $vars['ts'];
$token = $vars['token'];
$show_validate_link = false;

if ($user instanceof ElggUser) {
    $icon = elgg_view("profile/icon", array(
		'entity' => $user,
		'size' => 'small',
	    ));

    $body = "<p><b><a href=\"" . $user->getUrl() . "\">" .$user->name . "</a></b>";
    $body .= " (" . $vars['entity']->email  . ") ";
    $body .= "<b>" . elgg_echo('siteaccess:users:status') . ":</b> ";
    if ($user->validated) {
	$body .= "<font color='green'>" . elgg_echo('siteaccess:users:isuser:validated') . "</font>";
    } else {
	$body .= "<font color='red'>" . elgg_echo('siteaccess:users:isuser:unvalidated') . "</font>";
    }
    if (siteaccess_admin_validate_enabled() && ($user->getMetadata(admin_validated) != NULL)) {
        if ($user->admin_validated) {
	    $body .= "<font color='indigo'> " . elgg_echo('siteaccess:users:isadmin:validated') . "</font>";
	} else {
	    $show_validate_link = true;
	    $body .= "<font color='violet'> " . elgg_echo('siteaccess:users:isadmin:unvalidated') . "</font>";
	}
    }
    if ($user->isAdmin()) {
	$body .= "<font color='orange'> " . elgg_echo('siteaccess:users:isadmin') . "</font>";
    }
    if ($user->isBanned()) {
	$body .= "<font color='brown'> " . elgg_echo('siteaccess:users:isbanned') . "</font>";
    }
    if ($user->invited_by_guid) {
	$friend_user = get_entity($user->invited_by_guid);
	if ($friend_user)
	    $body .= "<br/>" . elgg_echo('siteaccess:users:invited') . " <b><a href=\"siteaccess?tab=invited&guid=$friend_user->guid\">" . $friend_user->name . "</a> (<a href=\"". $friend_user->getURL() ."\">" . p . "</a>)</b>";
    }
    $body .= "<br/><b>" . elgg_echo('siteaccess:users:lastlogin') . ": </b>" . date("F j, Y, g:i a", $user->last_login) . "";
    $body .= "<br/><b>" . elgg_echo('siteaccess:users:created') . ": </b>" . date("F j, Y, g:i a", $user->getTimeCreated()) . "";
    $body .= " ::: (". elgg_echo('siteaccess:admin:options') . "";
    if ($show_validate_link) {
	$body .= " " . elgg_view('output/url', array(
	    'text' => elgg_echo('siteaccess:admin:validate'),
	    'href' => "action/siteaccess/admin/validate?guid=$user->guid",
	    'is_action' => true,
	)) . ";";
    }
    if ($user->isBanned()) {
	$body .= " " . elgg_view('output/url', array(
	    'text' => elgg_echo('unban'),
	    'href' => "action/admin/user/unban?guid=$user->guid",
	    'is_action' => true,
	)) . ";";
    } else {
	$body .= " " . elgg_view('output/url', array(
	    'text' => elgg_echo('ban'),
	    'href' => "action/admin/user/ban?guid=$user->guid",
	    'is_action' => true,
	)) . ";";
    }
    $body .= " " . elgg_view('output/url', array(
	'text' => elgg_echo('delete'),
	'href' => "action/admin/user/delete?guid=$user->guid",
	'is_action' => true,
	'confirm' => true,
    )) . ";";
    if (!$user->isAdmin()) {
	$body .= " " . elgg_view('output/url', array(
	    'text' => elgg_echo('makeadmin'),
	    'href' => "action/admin/user/makeadmin?guid=$user->guid",
	    'is_action' => true,
	    'confirm' => true,
	));
    } else {
	$body .= " " . elgg_view('output/url', array(
	    'text' => elgg_echo('removeadmin'),
	    'href' => "action/admin/user/removeadmin?guid=$user->guid",
	    'is_action' => true,
	    'confirm' => true,
	));
    }
    $body .= " )";
    $body .= "</p>";


    echo elgg_view_image_block($icon, $body);
} else {
    echo elgg_echo('siteaccess:users:invalid');
}
?>
