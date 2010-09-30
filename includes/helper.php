<?php 

// Required classes:
$includes = APP_PATH . "includes";
require_once("$includes/class.phpmailer.php");
require_once("$includes/pchart/pChart/pData.class");
require_once("$includes/pchart/pChart/pChart.class");


function _n ( $number ) {
	if ( $number > 0 ) $number = '+'.$number;
	return $number;
}


function send_mail ( $to , $subject, $msg, $from = null, $from_name=null ) {

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
	//$mail_c->AltBody = "To view the message, please use an HTML compatible email viewer!";
	$mail_c->MsgHTML($msg);
	$mail_c->Send();
}

 //bar graph
function generate_image( $site_name, $visits ) {
	
	 $font = APP_PATH."includes/pchart/Fonts/tahoma.ttf";
	 //$font = APP_PATH."includes/pchart/Fonts/DejaVuSans.ttf";
	 
	 global $lang;

	 // Dataset definition 
	 $DataSet = new pData;

	 $names = array();
	 $points = array();
	 foreach ( $visits as $date => $visit ) {

		$points[] = $visit;

		$text = $lang['days'][date('N', strtotime($date))];
		$names[] = $text;
		 
	}

	 $DataSet->AddPoint($points,"Lankytojai");
	 $DataSet->AddPoint($names,"days");
	 $DataSet->AddAllSeries();
	 $DataSet->RemoveSerie("days");
	 $DataSet->SetAbsciseLabelSerie('days');


	 // Initialise the graph
	 $Test = new pChart(700,230);
	 $Test->setFontProperties($font,8);
	 $Test->setGraphArea(50,30,680,200);
	 $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
	 $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
	 $Test->drawGraphArea(255,255,255,TRUE);
	 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
	 $Test->drawGrid(4,TRUE,230,230,230,50);

	 // Draw the 0 line
	 $Test->setFontProperties($font,6);
	 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

	 // Draw the bar graph
	 $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,80);


	 // Finish the graph
	 $Test->setFontProperties($font,8);
//	 $Test->drawLegend(100,20,$DataSet->GetDataDescription(),255,255,255);
	 $Test->drawLegend(610,10,$DataSet->GetDataDescription(),236,238,240,52,58,82);
	 $Test->setFontProperties($font,10);
	 $Test->drawTitle(50,22,$site_name,50,50,50,585);
	 $path = IMAGE_PATH."$site_name.png";
	 if ( file_exists($path) )
		unlink($path);
	 $Test->Render($path);
	 return $path;

}

function filename ( $file ) {
	$ext = end(explode('.', $file));
	return basename($file,'.'.$ext);
}
