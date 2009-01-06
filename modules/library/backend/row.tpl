<tr>
	<td style="padding-left: {$this->current->get_depth()*20+10}px;"><img src="images/icons/folder.png" />&nbsp;<a href="{$this->url('admin', 'module', $this->get_module_name(), 'list_contents', $this->current->id)}">{$this->current->title|escape}</a></td>
	<td style="width: 80px;">
		<a href="{$this->url('admin', 'module', $this->get_module_name(), 'edit_folder', $this->current->id)}"><img src="images/icons/page_edit.png" /></a>
		<a href="{$this->url('admin', 'module', $this->get_module_name(), 'move_item', $this->current->id)}"><img src="images/icons/shape_move_forwards.png" /></a>
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