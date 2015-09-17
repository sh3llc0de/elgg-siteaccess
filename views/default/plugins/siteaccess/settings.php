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

$plugin = $vars['plugin'];

$checkboxes = array('logincaptcha', 'regcaptcha', 'coppa', 'sitepassword', 'adminvalidate', 'icbsp', 'icbav');
foreach ($checkboxes as $checkbox) {
    echo '<div>';
    echo '<label>';
    echo elgg_view('input/checkbox', array(
	'name' => "params[$checkbox]",
	'value' => true,
	'checked' => (bool)$plugin->$checkbox,
    ));
    echo ' ' . elgg_echo("siteaccess:settings:$checkbox");
    echo '</label>';
    echo '</div>';
}

echo '<div>' . elgg_echo('siteaccess:sitepassword:text');
echo elgg_view("input/text", array(
	'name' => 'params[sitepassword_value]',
	'value' => $plugin->sitepassword_value,
));
echo '</div>';

echo '<div>' . elgg_echo('siteaccess:login:failcount');
echo elgg_view("input/text", array(
	'name' => 'params[login_fail]',
	'value' => $plugin->login_fail,
));
echo '</div>';

echo '<div>' . elgg_echo('siteaccess:coppa:age');
echo elgg_view("input/text", array(
	'name' => 'params[coppa_age]',
	'value' => $plugin->coppa_age,
));
echo '</div>';
?>

<hr />
<b><?php echo elgg_echo('siteaccess:notify:options');
	 echo " (" . elgg_echo('siteaccess:notify:pending') . " " . siteaccess_count_users('admin_validated', '0') . ")";
?></b>
<p>
    <?php
        echo elgg_echo('siteaccess:notify');
		echo elgg_view('input/select', array(
                        'name' => 'params[period]',
                        'options_values' => array(
                                'hourly' => elgg_echo('siteaccess:hourly'),
                                'daily' => elgg_echo('siteaccess:daily'),
                                'weekly' => elgg_echo('siteaccess:weekly'),
								'monthly' => elgg_echo('siteaccess:monthly'),
                        ),
                        'value' => $plugin->period
                ));
        echo elgg_view('input/text', array('name' => "params[notify]", 'value' => $plugin->notify));
    ?>
</p>
