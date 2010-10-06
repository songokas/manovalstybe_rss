<h3><?php echo $title; ?></h3>
<?php if ( $nodes ) : ?>
<table border="1">
    <tbody>
	<tr>
	    <th>time</th><th>user</th><th>message</th>
	</tr>

	    <? foreach ( $nodes as $node ) { ?>
	<tr>
	    <td valign="top"><?=$node->date?></td>
	    <td valign="top"><?=$node->author?></td>
	    <td>
		<a href="<?=$node->title_link?>"><?=$node->title?></a>
	    </td>
	</tr>
		<? } ?>
	<tr></tr>
    </tbody>
</table>
<? else : ?>
<p><?php echo $empty;?></p><br/>
<? endif; ?>