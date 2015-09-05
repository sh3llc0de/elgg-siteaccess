<?php

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
