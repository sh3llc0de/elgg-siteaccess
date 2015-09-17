<?php
/*
Copyright (c) 2015, Wade Benson
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

The views and conclusions contained in the software and documentation are those
of the authors and should not be interpreted as representing official policies,
either expressed or implied, of the FreeBSD Project.
 */

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
