{assign var=module value=$this->current->get_module()}
<tr>
	<td style="width: 40px;">
		{if $this->current->can_move_up()}<a href="{$this->url('admin', 'module', $this->get_module_name(), 'move_up', $this->current->id)}"><img src="images/icons/arrow_up.png" /></a>{/if}
		{if $this->current->can_move_down()}<a href="{$this->url('admin', 'module', $this->get_module_name(), 'move_down', $this->current->id)}"><img src="images/icons/arrow_down.png" /></a>{/if}</td>
	<td style="padding-left: {$this->current->get_depth()*20-10}px;">{$this->current->title|escape} <a href="{$this->url('admin', 'module', $module->get_module_name())}" class="module">{$module->get_module_title()}</a></td>
	<td><a href="{$this->current->get_link()}">Naar pagina &raquo;</a></td>
	<td style="width: 56px;">
		<a href="{$this->url('admin', 'module', $this->get_module_name(), 'edit', $this->current->id)}"><img src="images/icons/page_edit.png" /></a>
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