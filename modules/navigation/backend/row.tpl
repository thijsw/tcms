<tr>
	<td style="width: 32px;">
		{if $this->current->can_move_up()}<img src="images/icons/arrow_up.png" />{/if}
		{if $this->current->can_move_down()}<img src="images/icons/arrow_down.png" />{/if}</td>
	<td style="padding-left: {$this->current->get_depth()*20-10}px;">{$this->current->title|escape}</td>
	<td><a href="{$this->get_uri($this->current)}">{$this->get_uri($this->current)}</a></td>
	<td style="width: 56px;">
		<a href="?admin/module/navigation/move_item/{$this->current->id}"><img src="images/icons/shape_move_forwards.png" /></a>
		<a href="?admin/module/navigation/add_item/{$this->current->id}"><img src="images/icons/add.png" /></a>
		<a href="?admin/module/navigation/delete_item/{$this->current->id}"><img src="images/icons/delete.png" /></a>
	</td>
</tr>
{if $this->current->has_children()}
	{foreach from=$this->current->get_children() item=item}
		{$this->set_current($item)}
		{$this->render('row')}
	{/foreach}
{/if}