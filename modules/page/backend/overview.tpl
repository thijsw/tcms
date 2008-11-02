<h1>Lijst van pagina's</h1>
<div id="inner">
	<table>
		<thead>
			<tr>
				<th>Titel</th>
				<th>Auteur</th>
				<th>Laatst bewerkt</th>
				<th>Acties</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$this->_get_all_pages() item=page}
			<tr>
				<td>{$page.title}</td>
				<td>{$page.name_first}</td>
				<td>{if $page.modified}{$page.modified}{else}{$page.created}{/if}</td>
				<td>bewerk / verwijder</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
</div>