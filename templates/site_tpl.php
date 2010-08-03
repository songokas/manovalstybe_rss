<table border="1">
	<tbody>
	<tr>
		<th>time</th><th>user</th><th>message</th>
	</tr>

<? foreach ( $xml->channel->item as $node ) {

	$date = date('Y-m-d', strtotime($node->pubDate));
	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $child = $node->children('dc');
	    $exist = true;
	    //var_dump((string)$node->description != (string)$node->title, $node->description , $node->title);?>
	    <tr>
		    <td valign="top"><?=$date?></td>
		    <td valign="top"><?=$child->creator?></td>
		    <td>
			<a href="<?=$node->link?>"><?=$node->title?></a>
			<div><?=$node->description?></div>
		    </td>
	    </tr>
	<? } ?>
<? } ?>
	<tr></tr>
	</tbody>
</table>