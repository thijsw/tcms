<h1>Navigatie over de website</h1>
<div id="inner">

	<!-- Areas -->
	{foreach from=$this->get_navigation_areas() item=area}
	<div class="area_header">
		<h2>{$area->title|escape}</h2>
		<p class="desc">{$area->desc|escape}</p>
	</div>

	<!-- Items -->
	<table>
		<thead>
			<tr>
				<th width="5%">&nbsp;</th>
				<th width="65%">Titel</th>
				<th width="20%">URI</th>
				<th width="10%">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$area->get_children() item=item}
				{$this->set_current($item)}
				{$this->render('row')}
				{foreachelse}
				<tr>
					<td colspan="4" style="text-align: center; padding: 2em;">
						<em>Er zijn geen items gevonden in dit menu</em>
					</td>
				</tr>
				{/foreach}
			<tr>
				<td colspan="4"><img src="images/icons/add.png"> <a href="{$this->url('admin', 'module', $this->get_module_name(), 'add_item', $area->id)}"><strong>Nieuw item aanmaken &raquo;</strong></a></td>
			</tr>
		</tbody>
	</table>
	
	{/foreach}

</div>