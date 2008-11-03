<h1>Lijst van pagina's</h1>
<div id="inner">
	<table>
		<thead>
			<tr>
				<th>Titel</th>
				<th>Auteur</th>
				<th>Laatst bewerkt</th>
				<th>Gepubliceerd</th>
				<th>Acties</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$this->_get_all_pages() item=page name=pages}
			<tr {if $smarty.foreach.pages.iteration % 2}class="odd"{/if}>
				<td>{$page.title|escape}</td>
				<td>{$page.name_first|escape} {$page.name_last|escape}</td>
				<td>{if $page.modified}{$page.modified|date_format:"%d-%m-%Y %H:%M"}{else}{$page.created|date_format:"%d-%m-%Y %H:%M"}{/if}</td>
				<td>{if $page.enabled}Ja{else}Nee{/if}</td>
				<td>
					<a href="?admin/module/page/edit/{$page.id}"><img src="images/icons/page_edit.png" /></a> <img src="images/icons/page_delete.png" /></td>
			</tr>
			{/foreach}
			<tr>
				<td colspan="5"><img src="images/icons/add.png"> <a href="?admin/module/page/create"><strong>Nieuwe pagina aanmaken &raquo;</strong></a></td>
			</tr>
		</tbody>
	</table>
</div>