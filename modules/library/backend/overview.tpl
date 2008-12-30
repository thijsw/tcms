<h1>Lijst met mappen</h1>
<div id="inner">
	<table>
		<thead>
			<tr>
				<th>Naam</th>
				<th>Acties</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$this->get_folders() item=folder}
			{$this->set_current($folder)}
			{$this->render('row')}
			{foreachelse}
			<tr>
				<td colspan="2" style="text-align: center; padding: 2em;">
					<em>Er zijn geen mappen gevonden</em>
				</td>
			</tr>
			{/foreach}
			<tr>
				<td colspan="2"><img src="images/icons/add.png"> <a href="{$this->url('admin', 'module', $this->get_module_name(), 'add_item')}"><strong>Nieuwe map aanmaken &raquo;</strong></a></td>
			</tr>
		</tbody>
	</table>
</div>