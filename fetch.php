<?php

require 'includes/config.php';
require 'includes/helper.php';
require 'includes/rss.php';

require 'includes/gapi.class.php';

if ( $config['generate_statistics'] ) {
    $ga = new gapi($config['ga_email'],$config['ga_password']);
    //get profile ids
    $ga->requestAccountData();
    foreach($ga->getResults() as $result)
    {
	    //var_dump(filename($result),(string)$result,$result->getProfileId() );
	    $config[filename((string)$result)]['profile_id'] = $result->getProfileId();
    }
}
/*
$profile_id =$config['kaveikiavaldzia']['profile_id'];
//last week visits
$visits = get_visits( $ga, $profile_id, $config['from'], $config['to']);
$prior_visits = get_visits( $ga, $profile_id, $config['prior_from'], $config['prior_to']);
$st = get_stats ( $visits, $prior_visits );
$image_path = generate_image('kaveikiavaldzia.lt', $visits);
$image_name = basename($image_path);
include 'templates/stats.php';
//var_dump($visits);
die;*/



//fetch rss
foreach ( $config['links'] as $site_name => $site ) {


    $atom_msg = '';
    $git_msg = '';
    $teambox_msg = '';
    $site_msg = '';
	$stat_msg = '';
    $url = $lang[$site_name];

    foreach ( $site as $type => $links ) {

        foreach ( $links as $key => $link ) {
            
            $xml = @simplexml_load_file($link);
            if ( ! $xml ) continue;

            switch ($type) {
            case 'git':
                $git_msg .= git_rss($xml, $link, $key);
                break;
            case 'teambox':
                $teambox_msg .= teambox_rss($xml, $url);
                break;
            case 'site':
                $site_msg .= site_rss($xml, $url);
                break;
            case 'atom':
                $atom_msg .= atom_rss($xml, $url);
            }
        }
    }

    $subject = $lang[$site_name] . ' savaitės apžvalga';
    ob_start();
    include 'templates/template.php';
    $msg=ob_get_clean();
    if ( $config['generate_statistics']) {
	if ( isset($config[$site_name]['profile_id']) ) {
		$profile_id = $config[$site_name]['profile_id'];
		//get stats

		//current week visits
		$visits = get_visits( $ga, $profile_id, $config['from'], $config['to']);
		$prior_visits = get_visits( $ga, $profile_id, $config['prior_from'], $config['prior_to']);
		$st = get_stats ( $visits, $prior_visits );
		$image_path = generate_image( $lang[$site_name], $visits);
		$image_name = basename($image_path);
		ob_start();
		include 'templates/stats.php';
		$stat_msg=ob_get_clean();
		
	}
	
    }
    $fmsg = sprintf($msg, $git_msg, $teambox_msg, $site_msg, $atom_msg, $stat_msg);
    echo $fmsg;
    echo '</br>';
    //send_mail($config['mail_to'], $subject, $fmsg, $config['mail_from'], 'manovalstybe.lt');
}
