<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lt" lang="lt">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>
    <body>
<p>Tai yra automatiškai suformuota <a href="<?=$config['current_url']?>"><?=$config['current_name']?></a> darbų ir naujienų ataskaita.</p>
<p>Laikotarpis: <?=$config['from']?> &mdash; <?=$config['to']?></p>

<?= $git ?>
<?= $site ?>
<?= $teambox ?>
<?= $stats ?>


<hr/>
<p>Šią ataskaitą suformavo programėlė, kurios kodas prieinamas: <a href="http://github.com/tomasj/manovalstybe_rss.git">http://github.com/tomasj/manovalstybe_rss.git</a>.</p>
    </body>
</html>

