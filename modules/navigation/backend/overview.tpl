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
				<th>&nbsp;</th>
				<th>Titel</th>
				<th>URI</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$area->get_children() item=item}
				{$this->set_current($item)}
				{$this->render('row')}
			{/foreach}
		</tbody>
	</table>
	
	{/foreach}

</div>