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

$tab = get_input('tab', 'all');
$offset = get_input('offset');
$limit = 10;
$context = elgg_get_context();

echo elgg_view('navigation/tabs', array(
	'tabs' => array(
		array(
			'text' => elgg_echo('siteaccess:users:taball'),
			'href' => 'admin/users/siteaccess',
			'selected' => ($tab == 'all'),
		),
		array(
			'text' => elgg_echo('siteaccess:users:tabinvited'),
			'href' => 'admin/users/siteaccess?tab=invited',
			'selected' => ($tab == 'invited'),
		),
		array(
			'text' => elgg_echo('siteaccess:users:tabbanned'),
			'href' => 'admin/users/siteaccess?tab=banned',
			'selected' => ($tab == 'banned'),
		),
		array(
			'text' => elgg_echo('siteaccess:users:tabadmin'),
			'href' => 'admin/users/siteaccess?tab=admin',
			'selected' => ($tab == 'admin'),
		),
		array(
			'text' => elgg_echo('siteaccess:users:tabadminvalidate'),
			'href' => 'admin/users/siteaccess?tab=adminvalidate',
			'selected' => ($tab == 'adminvalidate'),
		),
	    )
    ));

switch ($tab) {
    case 'adminvalidate':
	    if (siteaccess_admin_validate_enabled()) {
		    $count = siteaccess_count_users('admin_validated', '0');
		    $entities = siteaccess_users('admin_validated', '0', $limit, $offset);
	    } else {
		echo elgg_echo('siteaccess:users:admin:validate:disabled');
	    }
	    break;
    case 'admin':
	    $admins = elgg_get_admins();
	    $count = count($admins);
	    $entities = $admins;
	break;
    case 'banned':
	    $count = siteaccess_count_users('ban_reason', 'banned');
	    $entities = siteaccess_users('ban_reason', 'banned', $limit, $offset);
	break;
    case 'invited':
	    $guid = get_input('guid', NULL);
	    $count = siteaccess_count_users('invited_by_guid', $guid);
	    $entities = siteaccess_users('invited_by_guid', $guid, $limit, $offset);
	break;
    case 'all':
    default:
	    $query = get_input("query");
	    if (empty($query)) {
		$count = siteaccess_all_users_count();
		$entities = siteaccess_all_users($limit, $offset);
	    } else {
		$options = array();
		$options['query'] = $query;
		$options['type'] = "user";
		$options['offset'] = $offset;
		$options['limit'] = $limit;

		$results = elgg_trigger_plugin_hook('search', 'user', $options, array());
		$count = $results['count'];
		$entities = $results['entities'];
	    }
	break;
}

echo elgg_view('siteaccess/user_list',
            array(
                'entities' => $entities,
                'count' => $count,
                'offset' => $offset,
                'limit' => $limit,
                'baseurl' => $_SERVER['REQUEST_URI'],
                'context' => $context,
                'pagination' => true,
                'friend_guid' => $friend_guid
                ));

if ($tab == "all") {
    $params = array(
	'method' => 'get',
	'action' => 'admin/users/siteaccess',
	'disable_security' => true,
    );

    echo elgg_view_form('siteaccess/search', $params);

}

