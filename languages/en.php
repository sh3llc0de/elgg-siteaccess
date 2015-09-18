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

	return array(
		'admin:users:siteaccess' => 'Site Access',
		'admin:settings:siteaccess' => 'Site Access',
		'siteaccess:settings:main' => 'Primary Settings',
		'siteaccess:settings:coppa' => 'Require coppa to register?',
		'siteaccess:settings:sitepassword' => 'Require site Password to register?',
		'siteaccess:settings:regcaptcha' => 'Require captcha to register?',
		'siteaccess:settings:logincaptcha' => 'Require captcha to login after # failed attempts?',
		'siteaccess:settings:save:ok' => 'Successfully saved the siteaccess settings',
		'siteaccess:settings:adminvalidate' => 'Require admin validation?',
		'siteaccess:settings:icbsp' => 'Allow invite code to bypass site passcode?',
		'siteaccess:settings:icbav' => 'Allow invite code to bypass admin validation?',
		'siteaccess:settings:icreg' => 'Require invite code to register?',
		'siteaccess:settings:usernotify' => 'Notify user when admin activated',
		'siteaccess:sitepassword:text' => 'Enter site password',
		'siteaccess:sitepassword:invalid' => 'Invalid site password!',
		'siteaccess:reg:ic:required' => 'Invite code required to register on this server!',
		'siteaccess:login:failcount' => 'Enter # of login failures permitted before captcha (default: 3)',
		'siteaccess:coppa:text' => 'I am at least %s years of age',
		'siteaccess:coppa:fail' => 'You must be at least %s years of age to register for this website',
		'siteaccess:coppa:age' => 'Enter age required to use site? (default: 13)',
		'siteaccess:code:invalid' => 'Invalid captcha entered!',
		'siteaccess:users:status' => 'Status',
		'siteaccess:users:taball' => 'All users',
		'siteaccess:users:tabinvited' => 'Invited',
		'siteaccess:users:tabbanned' => 'Banned',
		'siteaccess:users:tabadmin' => 'Admin',
		'siteaccess:users:tabadminvalidate' => 'Waiting admin validation',
		'siteaccess:users:created' => 'Created',
		'siteaccess:users:lastlogin' => 'Last login',
		'siteaccess:users:isuser:validated' => 'user validated',
		'siteaccess:users:isuser:unvalidated' => 'user not validated',
		'siteaccess:users:isadmin:validated' => 'admin validated',
		'siteaccess:users:isadmin:unvalidated' => 'admin not validated',
		'siteaccess:users:isbanned' => 'banned',
		'siteaccess:users:isadmin' => 'admin',
		'siteaccess:users:invited' => 'invited by',
		'siteaccess:users:invalid' => 'invalid user',
		'siteaccess:validate:user' => 'User has been validated.',
		'siteaccess:admin:validate' => 'validate',
		'siteaccess:admin:options' => '',
		'siteaccess:users:admin:validate:disabled' => 'Require admin validation not activated',
		'siteaccess:admin:validation:fail' => 'Your account is waiting to be activated by the admin!',
		'siteaccess:notify' => 'Enter username to notify of new users in the validation queue?',
		'siteaccess:notify:options' => 'Notification Options',
		'siteaccess:notify:pending' => 'Pending Users:',
		'siteaccess:hourly' => 'hourly',
		'siteaccess:daily' => 'daily',
		'siteaccess:weekly' => 'weekly',
		'siteaccess:monthly' => 'monthly',
		'siteaccess:email:subject' => '[%s] You have users in your validation queue!',
		'siteaccess:email:body' => 'Hi %s,

You have %s users in your queue waiting to be validated.

%s',
		'siteaccess:notify:user:subject' => '[%s] Account Activated',
		'siteaccess:notify:user:body' => 'Hi %s,

Your account has now been activated.

%s',
	);
