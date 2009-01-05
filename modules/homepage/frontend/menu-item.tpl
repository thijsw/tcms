{foreach from=$tpl->item->get_children() item=item}
<li {if $item->is_active()}class="selected"{/if}><a href="{$item->get_link()}">{$item->title|escape}</a>
	{if $item->has_children()}
	<ul>
		{$tpl->set('item', $item)}
		{$this->render('menu-item')}
	</ul>
	{/if}
	</li>
{/foreach}