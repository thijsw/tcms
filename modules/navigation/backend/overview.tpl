<h1>Navigatie over de website</h1>
<div id="inner">

	<!-- Areas -->
	{foreach from=$this->get_navigation_areas() item=area}
	<div class="area_header">
		<h2>{$area.title|escape}</h2>
		<p class="desc">{$area.desc|escape}</p>
	</div>
	
	<!-- Items -->
	{foreach from=$this->get_navigation_items($area.id) item=item}
		{$item.title|escape}<br />
	{/foreach}
	
	{/foreach}

</div>