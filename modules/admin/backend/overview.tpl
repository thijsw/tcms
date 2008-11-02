<h1>Kies een module</h1>
<div id="inner">
	<ul id="modules">
		{foreach from=$rep->get_all_modules() item=module}
		<li>
				<a href="?admin/render_module/{$module->get_module_name()}">
					<img src="{$module->get_icon_path()}" /><br />
					{$module->get_module_title()}
				</a>
			</li>
		{/foreach}
	</ul>
	<br class="cb" />
</div>