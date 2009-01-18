{if $this->item}
	{$this->render('item')}
{else}
<div class="box">
	<h2>{$this->get_title()|escape}</h2>
	{foreach from=$this->get_items(0, 3) item=item}
	{assign var=author value=$item->get_author()}
	<h3>{$item->title|escape}</h3>
	<h4>{$author->name_first|escape} {$author->name_last|escape} &ndash; {$item->created|date_format:"%d %B %Y"}</h4>
	<p>{$item->intro|escape|library} <a href="{$item->get_link()}">Lees verder ...</a></p>
	{/foreach}
</div>
{/if}
<div class="box">
	<h2>Archief</h2>
	<table width="100%">
		{foreach from=$this->get_items() item=item}
		{assign var=author value=$item->get_author()}
		<tr>
			<td><a href="{$item->get_link()}">{$item->title|escape}</a> <span style="margin-left: 10px; color: #999; font-style: italic;">{$author->name_first|escape} {$author->name_last|escape}</span></td>
			<td>{$item->created|date_format:"%d-%m-%Y"}</td>
		</tr>
		{/foreach}
	</table>
</div>