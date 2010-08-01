
<table>
	<tbody>
	<tr>
		<th>time</th><th>user</th><th>message</th>
	</tr>  
	  
	<tr>
		<td><?=$date?></td>
		<td><?=$node->author?></td>
		<td>
			<p><a href="<?=$node->link;?>"><?=$node->title?></a></p>
			<? if ( !empty($node->description) && $node->description != $node->title) {
				echo $node->description;
			} ?>
		</td>
	</tr>  
	<tr></tr>
	</tbody>
</table>