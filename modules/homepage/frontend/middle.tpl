{if $this->item}
<div class="box">
	<h2>{$this->item->title|escape}</h2>
	<p>{$this->item->intro|escape|library}<br /><a href="{$this->item->get_link()|escape}">Lees verder ...</a></p>
</div>
{/if}

{assign var=n value=$rep->load_frontend('news')}
<div class="box">
	<h2>Laatste nieuws</h2>
	{foreach from=$n->get_items(0, 3) item=news}
	{assign var=author value=$news->get_author()}
	<h3>{$news->title|escape}</h3>
	<h4>{$author->name_first|escape} {$author->name_last|escape} &ndash; {$news->created|date_format:"%d %B %Y"}</h4>
	<p>{$news->intro|escape|library}<br /><a href="{$news->get_link()}">Lees verder ...</a></p>
	{/foreach}
</div>