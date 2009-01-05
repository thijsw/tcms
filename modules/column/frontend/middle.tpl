{if $this->item}
	{$this->render('item')}
{else}
<div class="box">
	<h2>{$this->get_title()|escape}</h2>
	{foreach from=$this->get_items(0, 3) item=column}
	<h3>{$column->title|escape}</h3>
	<h4>{$column->name|escape} &ndash; {$column->submission|date_format:"%d %B %Y"}</h4>
	<p>{$column->intro|escape} <a href="{$column->get_link()}">Lees verder ...</a></p>
	{/foreach}
</div>
{/if}
<div class="box">
	<h2>Archief</h2>
	<table width="100%">
		{foreach from=$this->get_items(3) item=column}
		<tr>
			<td><a href="{$column->get_link()}">{$column->title|escape}</a></td>
			<td>{$column->submission|date_format:"%d-%m-%Y"}</td>
		</tr>
		{/foreach}
	</table>
</div>