<div>
    <?php
	if (siteaccess_login_captcha_enabled() AND ($_SESSION['login_failure'] >= siteaccess_login_threshold()))
	    echo elgg_view('siteaccess/code', $vars);
    ?>
</div>
