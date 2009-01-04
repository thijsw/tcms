<h1>{$this->get_title()}</h1>
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
			{foreach from=$this->items item=item name=items}
			<tr {if $smarty.foreach.items.iteration % 2}class="odd"{/if}>
				<td>{$item->title|escape}</td>
				<td>{$item->name|escape}</td>
				<td>{$item->submission|date_format:"%d-%m-%Y"}</td>
				<td>
					<a href="{$this->url('admin', 'module', $this->get_module_name(), 'edit', $item->id)}"><img src="images/icons/page_edit.png" /></a>
					<a href="{$this->url('admin', 'module', $this->get_module_name(), 'delete', $item->id)}"><img src="images/icons/page_delete.png" /></a>
				</td>
			</tr>
			{foreachelse}
			<tr>
				<td colspan="4" style="text-align: center; padding: 2em;">
					<em>Er zijn geen items gevonden</em>
				</td>
			</tr>
			{/foreach}
			<tr>
				<td colspan="4"><img src="images/icons/add.png"> <a href="{$this->url('admin', 'module', $this->get_module_name(), 'create')}"><strong>Nieuwe column aanmaken &raquo;</strong></a></td>
			</tr>
		</tbody>
	</table>
</div>