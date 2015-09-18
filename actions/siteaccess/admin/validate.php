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

$guid = get_input('guid');
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);
$user = get_entity($guid);

if ($user instanceof ElggUser) {
    create_metadata($user->guid, 'admin_validated', true, '', 0, ACCESS_PUBLIC, false);
	if (elgg_get_plugin_setting('usernotify', 'siteaccess', false)) {
		$site = elgg_get_site_entity();
		$link = "{$site->url}";
		$subject = elgg_echo('siteaccess:notify:user:subject', array($site->name));
		$body = elgg_echo('siteaccess:notify:user:body', array($user->name, $link));
		notify_user($user->guid, $site->guid, $subject, $body, array(), 'email');
	}
    system_message(elgg_echo('siteaccess:validate:user'));
}

access_show_hidden_entities($access_status);

forward(REFERRER);

