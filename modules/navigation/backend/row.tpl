<tr>
	<td style="width: 32px;"><img src="images/icons/arrow_up.png" /><img src="images/icons/arrow_down.png" /></td>
	<td style="padding-left: {$this->current.depth*20+10}px;">{$this->current.title|escape}</td>
	<td><a href="{$this->get_uri($this->current)}">{$this->get_uri($this->current)}</a></td>
	<td style="width: 56px;">
		<a href="?admin/module/navigation/move_item/{$this->current.id}"><img src="images/icons/shape_move_forwards.png" /></a>
		<a href="?admin/module/navigation/add_item/{$this->current.id}"><img src="images/icons/add.png" /></a>
		<a href="?admin/module/navigation/delete_item/{$this->current.id}"><img src="images/icons/delete.png" /></a>
	</td>
</tr>
{if $this->current.haschildren}
	{foreach from=$this->get_navigation_items($this->current.area, $this->current.id) item=item}
		{$this->set_current($item)}
		{$this->render('row')}
	{/foreach}
{/if}