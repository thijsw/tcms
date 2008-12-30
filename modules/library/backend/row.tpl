<tr>
	<td style="padding-left: {$this->current->get_depth()*20+10}px;"><img src="images/icons/folder.png" />&nbsp;{$this->current->title|escape}</td>
	<td style="width: 56px;">
		<a href="{$this->url('admin', 'module', $this->get_module_name(), 'add_item', $this->current->id)}"><img src="images/icons/add.png" /></a>
		<a href="{$this->url('admin', 'module', $this->get_module_name(), 'delete_item', $this->current->id)}"><img src="images/icons/delete.png" /></a>
	</td>
</tr>
{if $this->current->has_children()}
	{foreach from=$this->current->get_children() item=item}
		{$this->set_current($item)}
		{$this->render('row')}
	{/foreach}
{/if}