<table border="1">
	<tbody>
	<tr>
		<th>time</th><th>user</th><th>message</th>
	</tr>

<? foreach ( $xml->entry as $node ) {
	$date = date('Y-m-d', strtotime($node->updated));
	if ( $date >= $config['from'] && $date <= $config['to']) {
	    $link_attr = $node->link->attributes();
	    $link = $link_attr['href'];
	    $exist = true;?>
	    <tr>
		    <td valign="top"><?=$date?></td>
		    <td valign="top"><a href="<?=$node->author->uri?>"><?=$node->author->name?></a></td>
		    <td> 
			<a href="<?=$link?>"><?=$node->title?></a>
		    </td>
	    </tr>
	<? } ?>
<? } ?>
	<tr></tr>
	</tbody>
</table>