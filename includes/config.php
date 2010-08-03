<?php

error_reporting(E_ALL ^ E_NOTICE);
mb_internal_encoding("UTF-8");
define('DROOT', $_SERVER['DOCUMENT_ROOT'].'/');
define('HOST', 'http://www.manovalstybe.lt/');
//define('HOST', '/');
define('APP_PATH', DROOT.'__scripts/');
define('IMAGE_PATH', APP_PATH."cache/");
define('IMAGE_URL', HOST."__scripts/cache/");



//gapi settings
$config['ga_email'] = 'manovalstybe.analytics@gmail.com';
$config['ga_password'] = '';
//this is not required since the script should fetch profile id itself
$config['kaveikiavaldzia']['ga_profile_id'] = '25250222';
$config['generate_statistics'] = 1;

//emails
$config['mail_to'] = 'manovalstybe@googlegroups.com';
$config['mail_from'] = 'apzvalga@manovalstybe.lt';

//dates
if ( date('w') == 1 ) $config['from'] = date('Y-m-d', strtotime('-1 monday'));
else $config['from'] = date('Y-m-d', strtotime('-2 monday'));

$config['to'] = date('Y-m-d', strtotime('-1 sunday'));

$config['prior_from'] = date('Y-m-d', strtotime($config['from'].' -1 week'));
$config['prior_to'] = date('Y-m-d', strtotime($config['to'].' -1 week'));

//rss links
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


$lang['manovalstybe'] = 'ManoValstybe.lt';
$lang['parasykjiems'] = 'ParasykJiems.lt';
$lang['kaveikiavaldzia'] = 'KaVeikiaValdzia.lt';

$lang['atom_title'] = '<h3>Diskusijos:</h3>';
$lang['teambox_title'] = '<h3>Teambox diskusijos ir darbai:</h3>';
$lang['site_title'] = '<h3><a href="http://%s">%s</a> tinklaraščio naujienos:</h3>';
$lang['git_title'] = '<h3><a href="%s">%s</a> kodo pakeitimai:</h3>';

$lang['nochanges'] = '<p>Pakeitimu nera.</p><br/>';
$lang['nonews'] = '<p>Naujienu nera.</p><br/>';
//pchart utf-8 support issues
$lang['days'] = array(1=>'Pir', 'Ant', 'Tre', 'Ket', 'Pen', 'Šeš','Sek');