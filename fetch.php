<?php

$config['mail_to'] = 'manovalstybe@googlegroups.com';
$config['mail_from'] = 'apzvalga@manovalstybe.lt';

$config['links']['manovalstybe']['site'][] = 'http://manovalstybe.lt/feed/';
$config['links']['manovalstybe']['site'][] = 'http://manovalstybe.lt/en/feed/';
$config['links']['manovalstybe']['git']['manovalstybe-wp-theme'] = 'http://github.com/emilis/manovalstybe-wp-theme/commits/master.atom';
$config['links']['manovalstybe']['git']['manovalstybe_rss'] = 'http://github.com/tomasj/manovalstybe_rss/commits/master.atom';

$config['links']['parasykjiems']['git']['parasykjiems'] = 'http://bitbucket.org/dariusdamalakas/parasykjiems/atom';
$config['links']['parasykjiems']['teambox'][] = 'http://teambox.com/projects/parasykjiems.rss?rss_token=aa3b431326f0f22fc43c09917606dde90eabb872103888';
//
$config['links']['kaveikiavaldzia']['git']['PolicyFeed'] = 'http://github.com/emilis/PolicyFeed/commits/master.atom';
$config['links']['kaveikiavaldzia']['git']['kaveikiavaldzia-design'] = 'http://github.com/emilis/kaveikiavaldzia-design/commits/master.atom';
$config['links']['kaveikiavaldzia']['teambox'][] = 'http://teambox.com/projects/kaveikiavaldzia.rss?rss_token=aa3b431326f0f22fc43c09917606dde90eabb872103888';
//$config['links']['kaveikiavaldzia']['atom'][] = 'http://www.facebook.com/feeds/page.php?format=atom10&id=248440466844';

if ( date('w') == 1 ) $config['from'] = date('Y-m-d', strtotime('-1 monday'));
else $config['from'] = date('Y-m-d', strtotime('-2 monday'));

$config['to'] = date('Y-m-d', strtotime('-1 sunday'));


$lang['manovalstybe'] = 'ManoValstybe.lt';
$lang['parasykjiems'] = 'ParasykJiems.lt';
$lang['kaveikiavaldzia'] = 'KaVeikiaValdzia.lt';

$lang['atom_title'] = '<h3>Diskusijos:</h3>';
$lang['teambox_title'] = '<h3>Teambox diskusijos ir darbai:</h3>';
$lang['site_title'] = '<h3><a href="http://%s">%s</a> tinklaraščio naujienos:</h3>';
$lang['git_title'] = '<h3><a href="%s">%s</a> kodo pakeitimai:</h3>';

$lang['nochanges'] = '<p>Pakeitimų nėra.</p><br/>';
$lang['nonews'] = '<p>Naujienų nėra.</p><br/>';


function send_mail ( $to , $subject, $msg, $from = null, $from_name=null ) {
	require_once("includes/class.phpmailer.php");
    	$mail_c = new PHPMailer();
	if ( $from ) {
	    $mail_c->From = $from;
	    $mail_c->FromName = $from_name;
	}
	//$mail_c->Sender ="info@tebbuilders.com";
//	
	$mail_c->AddAddress($to);
	$mail_c->WordWrap = 50;
	$mail_c->Subject = $subject;
	$mail_c->AltBody = "To view the message, please use an HTML compatible email viewer!";
	$mail_c->MsgHTML($msg);
	$mail_c->Send();
}


function git_rss ( $xml, $site, $module ) {
    global $lang, $config;
    $msg = '';
    foreach ( $xml->entry as $node ) {
	$date = date('Y-m-d', strtotime($node->updated));
//	var_dump($date, $config['to'], $date >= $config['from'] && $date <= $config['to']);
	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $link_attr = $node->link->attributes();
	    $link = $link_attr['href'];
	    ob_start();
	    include 'templates/git_tpl.php';
	    $msg.=ob_get_clean();
	}
    }
    $pos = strpos($site, $module);
    $site = substr($site, 0 , $pos);
    $l = sprintf($lang['git_title'], $site.$module, $module);
    return $msg ?  $l.$msg: $l.$lang['nochanges'];
    
}

function teambox_rss ( $xml, $site ) {
    global $lang, $config;
    $msg = '';
//    var_dump($xml->channel);
    foreach ( $xml->channel->item as $node ) {
	$date = date('Y-m-d', strtotime($node->pubDate));
	if ( $date >= $config['from'] && $date <= $config['to']) {
	    ob_start();
	    include 'templates/teambox_tpl.php';
	    $msg.=ob_get_clean();
	}
    }
    $l = $lang['teambox_title'];
    return $msg ? $l.$msg : $l.$lang['nonews'];

}

function site_rss ( $xml, $site ) {
    global $lang, $config;
    $msg = '';
//    var_dump($xml->channel);
    foreach ( $xml->channel->item as $node ) {
	$date = date('Y-m-d', strtotime($node->pubDate));
	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $child = $node->children('dc');
	    ob_start();
	    include 'templates/site_tpl.php';
	    $msg.=ob_get_clean();
	}
    }
    $l = sprintf($lang['site_title'], $site, $site);
    return $msg ? $l.$msg : $l.$lang['nonews'];

}

function atom_rss ( $xml, $site ) {
    global $lang, $config;
    $msg = '';
    foreach ( $xml->entry as $node ) {
	$date = date('Y-m-d', strtotime($node->updated));
//	var_dump($date, $config['to'], $date >= $config['from'] && $date <= $config['to']);
	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $link_attr = $node->link->attributes();
	    $link = $link_attr['href'];
	    ob_start();
	    include 'templates/git_tpl.php';
	    $msg.=ob_get_clean();
	}
    }

    $l = $lang['atom_title'];
    return $msg ?  $l.$msg: $l.$lang['nonews'];
}


foreach ( $config['links'] as $site_name => $site ) {


    $atom_msg = '';
    $git_msg = '';
    $teambox_msg = '';
    $site_msg = '';
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
    $fmsg = sprintf($msg, $git_msg, $teambox_msg, $site_msg, $atom_msg);
//    echo $fmsg;
//    echo '</br>';
    send_mail($config['mail_to'], $subject, $fmsg, $config['mail_from'], 'manovalstybe.lt');
}
