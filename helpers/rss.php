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
		$gapi->requestReportData($profile_id,array('browser','browserVersion'),array('pageviews','visits'), null, null, $dfrom, $dfrom);
		$arr[$dfrom] = $gapi->getVisits();
		$dfrom = date('Y-m-d', strtotime("$dfrom + 1 day"));
		$day++;
		
	}
	return $arr;
}




function git_rss ( $xml, $site, $module ) {
    global $lang, $config;
    
//    $msg = '';
//
//    ob_start();
//    include APP_PATH . 'templates/git_tpl.php';
//    $msg=ob_get_clean();
//
//    $pos = strpos($site, $module);
//    $site = substr($site, 0 , $pos);
//    $l = sprintf($lang['git_title'], $site.$module, $module);
//    return $exist ?  $l.$msg: $l.$lang['nochanges'];
//    var_dump($xml);die;
    
    $arr = array();
    foreach ( $xml->entry as $node ) {
	$date = date('Y-m-d', strtotime($node->updated));
	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $link_attr = $node->link->attributes();
	    $obj = new stdClass();
	    $obj->date = $date;
	    $obj->author = $node->author->name;
//	    $obj->author_link = $node->author->uri;
	    $obj->description = $node->description;
	    $obj->title = $node->title;
	    $obj->title_link = $link_attr['href'];
	    $arr['nodes'][] = $obj;

	 }
    }

    $arr['empty'] = $lang['nochanges'];
    $arr['title'] = sprintf($lang['git_title'], $site.$module, $module);
    return $arr;
    
}

function teambox_rss ( $xml, $site ) {
    global $lang, $config;
//
//    ob_start();
//    include APP_PATH . 'templates/teambox_tpl.php';
//    $msg=ob_get_clean();
//
//    $l = $lang['teambox_title'];
//    return $exist ? $l.$msg : $l.$lang['nonews'];
    $arr = array();
    foreach ( $xml->channel->item as $node ) {
	$date = date('Y-m-d', strtotime($node->pubDate));
//	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $obj = new stdClass();
	    $obj->date = $date;
	    $obj->author = $node->author;
	    $obj->title = $node->title;
	    $obj->description = $node->description;
	    $arr['nodes'][] = $obj;
//	 }
    }

    $arr['empty'] = $lang['nonews'];
    $arr['title'] = $lang['teambox_title'];

    return $arr;

}

function site_rss ( $xml, $site ) {
    global $lang, $config;
//    $msg = '';
//    ob_start();
//    include APP_PATH . 'templates/site_tpl.php';
//    $msg=ob_get_clean();
//    $l = sprintf($lang['site_title'], $site, $site);
//    return $exist ? $l.$msg : $l.$lang['nonews'];
    $arr = array();
    foreach ( $xml->channel->item as $node ) {
	$date = date('Y-m-d', strtotime($node->pubDate));
//	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $child = $node->children('http://purl.org/dc/elements/1.1/');
	    $obj = new stdClass();
	    $obj->date = $date;
	    $obj->author = $child->creator;
//	    $obj->author_link = $node->author->uri;
	    $obj->description = $node->description;
	    $obj->title = $node->title;
	    $obj->title_link = $node->link;
	    $arr['nodes'][] = $obj;
//	 }
    }

    $arr['empty'] = $lang['nonews'];
    $arr['title'] = sprintf($lang['site_title'], $site, $site);

    return $arr;
}

//function atom_rss ( $xml, $site ) {
////    global $lang, $config;
////    $msg = '';
////
////    ob_start();
////    include APP_PATH . 'templates/git_tpl.php';
////    $msg=ob_get_clean();
////
////    $l = $lang['atom_title'];
////    return $exist ?  $l.$msg: $l.$lang['nonews'];
//}

function site_stats ( $site_name ) {

    global $lang, $config;
    
    if ( $config['generate_statistics']) {
	$ga = new gapi($config['ga_email'],$config['ga_password']);
	//get profile ids
	$ga->requestAccountData();
	foreach($ga->getResults() as $result)
	{
		$config[filename((string)$result)]['profile_id'] = $result->getProfileId();
	}
	if ( isset($config[$site_name]['profile_id']) ) {

		$profile_id = $config[$site_name]['profile_id'];

		//current week visits
		$arr['visits'] = get_visits( $ga, $profile_id, $config['from'], $config['to']);
		$arr['prior_visits'] = get_visits( $ga, $profile_id, $config['prior_from'], $config['prior_to']);
		$arr['st'] = get_stats( $arr['visits'], $arr['prior_visits'] );
		$arr['image_path'] = generate_image( $lang[$site_name], $arr['visits']);
		$arr['image_name'] = basename($arr['image_path']);
		return $arr;

	}

    }
}

function process_site( $site_arr ) {
    
    $arr = array();
    foreach ( $site_arr as $type => $links ) {
        foreach ( $links as $key => $link ) {

            $xml = @simplexml_load_file($link);
            if ( ! $xml ) continue;

            switch ($type) {
            case 'git':
                $nodes = git_rss($xml, $link, $key);
                break;
            case 'teambox':
                $nodes = teambox_rss($xml, $link);
                break;
            case 'site':
                $nodes = site_rss($xml, $link);
                break;
            case 'atom':
                $nodes = git_rss($xml, $link);
            }
	    $arr[$type] = $nodes;

        }
    }
    return $arr;
}