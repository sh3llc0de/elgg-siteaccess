<div>
    <?php
	if (siteaccess_site_password_enabled())
	    echo "<label>" . elgg_echo('siteaccess:sitepassword:text') . "<br />" . elgg_view('input/password' , array('name' => 'siteaccesspassword', 'value' => $siteaccesspassword, 'class' => "general-textarea")) . "</label><br />";
	if (siteaccess_coppa_enabled())
	    echo "<label><br />" . elgg_view('input/checkbox' , array('name' => 'coppa', 'value' => true, 'label' => elgg_echo('siteaccess:coppa:text'))) . "</label><br />";

	if (siteaccess_reg_captcha_enabled())
	    echo elgg_view('siteaccess/code', $vars);

    ?>
</div>
