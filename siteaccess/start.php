<?php

elgg_register_event_handler('init', 'system', 'siteaccess_init');

function siteaccess_init() {
	elgg_register_admin_menu_item('administer', 'siteaccess', 'users');
	elgg_register_admin_menu_item('configure', 'siteaccess', 'settings');

	$action_path = dirname(__FILE__) . '/actions/siteaccess';
	elgg_extend_view('register/extend', 'siteaccess/registration');
	elgg_extend_view('login/extend', 'siteaccess/login');

	elgg_register_page_handler('siteaccess', 'siteaccess_code_page_handler');
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'siteaccess_public_pages');

	elgg_extend_view('css/elgg', 'siteaccess/css');

	elgg_register_plugin_hook_handler('action', 'register', 'siteaccess_register_hook');
	elgg_register_plugin_hook_handler('register', 'user', 'siteaccess_register_update');
	elgg_register_plugin_hook_handler('action', 'login', 'siteaccess_login_hook');

	elgg_register_action("siteaccess/admin/settings", "$action_path/admin/settings.php", 'admin');
	elgg_register_action("siteaccess/admin/validate", "$action_path/admin/validate.php", 'admin');

	elgg_register_event_handler('login:before', 'user', 'siteaccess_check_validation');

	$period = elgg_get_plugin_setting('period','siteaccess');
	if (!$period) $period = 'daily';
        elgg_register_plugin_hook_handler('cron', $period, 'siteaccess_cron_hook');
}

function siteaccess_coppa_enabled()
{
	return elgg_get_plugin_setting('coppa', 'siteaccess');
}

function siteaccess_admin_validate_enabled()
{
	return elgg_get_plugin_setting('adminvalidate', 'siteaccess');
}

function siteaccess_site_password_enabled()
{
	if (elgg_get_plugin_setting('icbsp', 'siteaccess')) {
	    $params = array(
		'friend_guid' => get_input('friend_guid'),
		'invitecode' => get_input('invitecode'),
	    );
	    if (siteaccess_validate_invitecode($params)) {
		return false;
	    }
	}
	return elgg_get_plugin_setting('sitepassword', 'siteaccess');
}

function siteaccess_reg_captcha_enabled()
{
    if (!extension_loaded("gd"))
	return false;

    return elgg_get_plugin_setting('regcaptcha', 'siteaccess');
}

function siteaccess_login_captcha_enabled()
{
    if (!extension_loaded("gd"))
	return false;

    return elgg_get_plugin_setting('logincaptcha', 'siteaccess');
}

function siteaccess_login_threshold()
{
    $threshold = intval(elgg_get_plugin_setting('login_fail', 'siteaccess'));
    if (! $threshold ) {
	$threshold = 3;
    }
    return $threshold;
}

function siteaccess_generate_captcha($num) {
	global $CONFIG;
	$date = date("F j");
	$tmp = hexdec(md5($num . $date . $CONFIG->site->url . get_site_secret()));
	$code = substr($tmp, 4, 6);

	return $code;
}

function siteaccess_validate_captcha() {
	$code = get_input('code');
	$random = get_input('random');

	$generated_code = siteaccess_generate_captcha($random);
	$valid = false;
	if ((trim($code) != "") && (strcmp($code, $generated_code) == 0))
			$valid = true;
	else
		register_error(elgg_echo('siteaccess:code:invalid'));

	return $valid;
}

function siteaccess_validate_invitecode($params) {
    $valid = false;
    $friend_guid = $params['friend_guid'];
    $invite_code = $params['invitecode'];

    if ($friend_guid) {
	if ($friend_user = get_user($friend_guid)) {
	    if (elgg_validate_invite_code($friend_user->username, $invite_code)) {
		$valid = true;
	    }
	}
    }

    return $valid;
}

function siteaccess_code_page_handler($page) {
	$valid_pages = array('code');

	if (empty($page[0]) || !in_array($page[0], $valid_pages)) {
		forward('', '404');
	}

	switch ($page[0]) {
		case "code":
			$tmp = get_input('c');
			$code = siteaccess_generate_captcha($tmp);
			$images_path = dirname(__FILE__) . '/images';
			$image = ImageCreateFromJPEG("$images_path/code.jpg");
			$text_color = ImageColorAllocate($image, 80, 80, 80);
			Header("Content-type: image/jpeg");
			ImageString ($image, 5, 12, 2, $code, $text_color);
			ImageJPEG($image, NULL, 75);
			ImageDestroy($image);
			die();
			break;
		default:
			break;
	}
	return true;
}

function siteaccess_public_pages($hook, $type, $return_value, $params) {
	$return_value[] = 'siteaccess/code';

	return $return_value;
}

function siteaccess_register_hook($hook, $type, $result, $params) {
	$error = false;
	if (siteaccess_reg_captcha_enabled()) {
	    if (!siteaccess_validate_captcha()) {
		$error = true;
	    }
	}

	if (siteaccess_site_password_enabled()) {
	    $sitepassword = elgg_get_plugin_setting('sitepassword_value', 'siteaccess');
	    $inputpassword = get_input('siteaccesspassword');
	    if ((trim($inputpassword) == "") || (strcmp($inputpassword, $sitepassword) != 0)) {
		register_error(elgg_echo('siteaccess:sitepassword:invalid'));
		$error = true;
	    }
	}

	if (siteaccess_coppa_enabled()) {
	    $coppa = get_input('coppa');
	    if (!$coppa) {
		register_error(elgg_echo('siteaccess:coppa:fail'));
		$error = true;
	    }
	}

	return $error ? false : true;
}

function siteaccess_register_update($hook, $type, $result, $params) {
	$user = $params['user'];
	$friend_guid = $params['friend_guid'];
	$valid_invite_code = siteaccess_validate_invitecode($params);
	if ($valid_invite_code) {
	    create_metadata($user->guid, 'invited_by_guid', $friend_guid, '', 0, ACCESS_PUBLIC);
	}
	if (siteaccess_admin_validate_enabled()) {
	    $validated = false;
	    if (elgg_get_plugin_setting('icbav', 'siteaccess')) {
		if ($valid_invite_code) {
		    $validated = true;
		}
	    }
	    $user->admin_validated = $validated;
	}
}

function siteaccess_login_hook($hook, $type, $result, $params) {
	if (siteaccess_login_captcha_enabled()) {
	    $username = get_input('username');
	    $password = get_input('password', null, false);

	    if (empty($username) || empty($password)) {
		return true; // if not set bail
	    }

	    // check if logging in with email address
	    if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
		$username = $users[0]->username;
	    }

	    $user = get_user_by_username($username);
	    if (!$user) {
		return true; // doesn't exit bail
	    }

	    if (! $_SESSION['login_failure'] ) {
		$_SESSION['login_failure'] = (int)$user->getPrivateSetting("login_failures");
	    }

	    if ($_SESSION['login_failure'] >= siteaccess_login_threshold())
		    if (!siteaccess_validate_captcha())
			    return false; // require captcha

	    if (elgg_authenticate($username, $password) !== true) {
		    $_SESSION['login_failure']++;
		    return false;
	    } else {
		    $_SESSION['login_failure'] = 0;
	    }
	}
	return true;
}

function siteaccess_check_validation($event, $type, $user) {
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);
	if (siteaccess_admin_validate_enabled()) {
	    if ($user instanceof ElggUser) {
		if ($user->isAdmin()) {
		    $user->admin_validated = true;
		} else if (($user->getMetadata(admin_validated) != NULL) && !$user->admin_validated) {
		    access_show_hidden_entities($access_status);
		    throw new LoginException(elgg_echo('siteaccess:admin:validation:fail'));
		}
	    }
	}
	access_show_hidden_entities($access_status);
}

function siteaccess_count_users($meta_name, $meta_value) {
    $access_status = access_get_show_hidden_status();
    access_show_hidden_entities(TRUE);
    if(isset($meta_name)) {
	$options = array(
                        'metadata_name' => $meta_name,
                        'metadata_value' => $meta_value,
			'count' => true,
			'type' => 'user',
                );
	$count = elgg_get_entities_from_metadata($options);
    }
    access_show_hidden_entities($access_status);
    return $count;
}

function siteaccess_users($meta_name, $meta_value, $limit = 10, $offset = 0) {
    $access_status = access_get_show_hidden_status();
    access_show_hidden_entities(TRUE);
    if(isset($meta_name)) {
	$options = array(
                        'metadata_name' => $meta_name,
                        'metadata_value' => $meta_value,
			'limit' => $limit,
			'offset' => $offset,
			'type' => 'user',
                );
        $entities = elgg_get_entities_from_metadata($options);
    }
    access_show_hidden_entities($access_status);
    return $entities;
}

function siteaccess_all_users_count() {
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);
	$options = array(
			'count' => true,
			'type' => 'user',
		);
	$count = elgg_get_entities($options);
	access_show_hidden_entities($access_status);
        return $count;
}

function siteaccess_all_users($limit = 10, $offset = 0) {
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);
	$options = array(
			'limit' => $limit,
			'offset' => $offset,
			'type' => 'user',
		);
	$entities = elgg_get_entities($options);
	access_show_hidden_entities($access_status);
    return $entities;
}

function siteaccess_cron_hook($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;

	if (siteaccess_admin_validate_enabled()) {
		$site = elgg_get_site_entity();

		$username = elgg_get_plugin_setting('notify', 'siteaccess');
		if ($username) {
		    $count = siteaccess_count_users('admin_validated', '0');
		    if ($count > 0) {
			$user = get_user_by_username($username);
			if ($user) {
			    $link = "{$site->url}admin/users/siteaccess?tab=adminvalidate";
			    $subject = elgg_echo('siteaccess:email:subject', array($site->name));
			    $body = elgg_echo('siteaccess:email:body', array($user->name, "$count", $link));
			    notify_user($user->guid, $site->guid, $subject, $body, array(), 'email');
			}
		    }
		}
	}
}

