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
?>
<div>
    <?php
	if (siteaccess_site_password_enabled())
	    echo "<br /><label>" . elgg_echo('siteaccess:sitepassword:text') . "<br />" . elgg_view('input/password' , array('name' => 'siteaccesspassword', 'value' => $siteaccesspassword, 'class' => "general-textarea")) . "</label><br />";
	if (siteaccess_coppa_enabled()) {
		$age = elgg_get_plugin_setting('coppa_age', 'siteaccess', '13');
		if (!$age) $age = 13;
		echo "<br /><label>" . elgg_view('input/checkbox' , array('name' => 'coppa', 'value' => true, 'label' => elgg_echo('siteaccess:coppa:text', array($age)))) . "</label><br />";
	}

	if (siteaccess_reg_captcha_enabled()) {
		echo elgg_view('siteaccess/code', $vars);
	}

    ?>
</div>
