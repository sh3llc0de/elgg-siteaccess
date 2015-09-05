<?php

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

