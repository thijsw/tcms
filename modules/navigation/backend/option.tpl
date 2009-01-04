<!-- Geef het verplaatste item niet weer -->
{if $this->current !== $this->item}
<option value="{$this->current->id}">{section name=level loop=$this->current->get_depth()}&mdash; {/section}
 {$this->current->title|escape}</option>
{/if}
{if $this->current->has_children()}
	{foreach from=$this->current->get_children() item=item}
		{$this->set_current($item)}
		{$this->render('option')}
	{/foreach}
{/if}