<?php 

function get_stats( $visits, $prior_visits ){
	$st['current']['max'] = max($visits);
	$st['current']['avg'] = ceil(array_sum($visits)/count($visits));
	$st['current']['min'] = min($visits);
	$st['prior']['max'] = max($prior_visits);
	$st['prior']['avg'] = ceil(array_sum($prior_visits)/count($prior_visits));
	$st['prior']['min'] = min($prior_visits);
	$st['diff']['max'] = $st['current']['max'] - $st['prior']['max'];
	$st['diff']['avg'] = $st['current']['avg'] - $st['prior']['avg'];
	$st['diff']['min'] = $st['current']['min'] - $st['prior']['min'];
	return $st;
}

function get_visits( $gapi, $profile_id, $from, $to ) {

	$day = 0;
	$dfrom = $from;
	$arr = array();
	while ( $dfrom <= $to && $day < 7) {
	//var_dump($dfrom , $to);
		$gapi->requestReportData($profile_id,array('browser','browserVersion'),array('pageviews','visits'), null, null, $dfrom, $to);
		$arr[$dfrom] = $gapi->getVisits();
		$dfrom = date('Y-m-d', strtotime("$dfrom + 1 day"));
		$day++;
		
	}
	return $arr;
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
