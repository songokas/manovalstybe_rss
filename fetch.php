<?php
define('DROOT', dirname(dirname(__FILE__)) . '/');
define('APP_PATH', DROOT.'__scripts/');

require APP_PATH.'configs/app.php';
require APP_PATH.'configs/config.php';
require APP_PATH.'helpers/helper.php';
require APP_PATH.'helpers/rss.php';

//fetch rss
foreach ( $config['links'] as $site_name => $site ) {

    $tpl = new Template();
    $arr_sites = process_site($site);
    foreach ( $arr_sites as $type => $elem ) {
	$tpl->load($type, 'rss_template', $elem);
    }

    $arr_stats = site_stats($site_name);
    if ( $arr_stats )
	$tpl->load('stats', 'stats', $arr_stats);

    $config['current_url'] = $lang['url'][$site_name];
    $config['current_name'] = $lang[$site_name];
    $fmsg = $tpl->render(true);

//    echo $fmsg;
//    echo '</br>';
    send_mail($config['mail_to'], $subject, $fmsg, $config['mail_from'], 'manovalstybe.lt');
}
