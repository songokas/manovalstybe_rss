<?php

//gapi settings
$config['ga_email'] = 'manovalstybe.analytics@gmail.com';
$config['ga_password'] = '';
//this is not required since the script should fetch profile id itself
$config['kaveikiavaldzia']['ga_profile_id'] = '25250222';
$config['generate_statistics'] = 0;

//emails
$config['mail_to'] = 'manovalstybe@googlegroups.com';
$config['mail_from'] = 'apzvalga@manovalstybe.lt';

//dates
$config['from'] = date('Y-m-d', strtotime('-7 days')); 
$config['to'] = date('Y-m-d', time());

//stat dates
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
$config['links']['kaveikiavaldzia']['git']['PolicyFeed:development'] = 'http://github.com/emilis/PolicyFeed/commits/development.atom';
$config['links']['kaveikiavaldzia']['git']['kaveikiavaldzia-design'] = 'http://github.com/emilis/kaveikiavaldzia-design/commits/master.atom';
$config['links']['kaveikiavaldzia']['teambox'][] = 'http://teambox.com/projects/kaveikiavaldzia.rss?rss_token=aa3b431326f0f22fc43c09917606dde90eabb872103888';
//$config['links']['kaveikiavaldzia']['atom'][] = 'http://www.facebook.com/feeds/page.php?format=atom10&id=248440466844';


$lang['manovalstybe'] = 'ManoValstybe.lt';
$lang['parasykjiems'] = 'ParasykJiems.lt';
$lang['kaveikiavaldzia'] = 'KaVeikiaValdzia.lt';
$lang['url']['manovalstybe'] = 'http://www.manovalstybe.lt';
$lang['url']['parasykjiems'] = 'http://www.parasykjiems.lt';
$lang['url']['kaveikiavaldzia'] = 'http://www.kaveikiavaldzia.lt';

$lang['atom_title'] = 'Diskusijos:';
$lang['teambox_title'] = 'Teambox diskusijos ir darbai:';
$lang['site_title'] = '<a href="%s">%s</a> tinklaraščio naujienos:';
$lang['git_title'] = '<a href="%s">%s</a> kodo pakeitimai:';

$lang['nochanges'] = 'Pakeitimu nera.';
$lang['nonews'] = 'Naujienu nera.';
//pchart utf-8 support issues
$lang['days'] = array(1=>'Pir', 'Ant', 'Tre', 'Ket', 'Pen', 'Šeš','Sek');
