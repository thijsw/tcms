<h1>Kies een module</h1>
<div id="inner">
	<ul id="modules">
		{foreach from=$rep->get_all_modules('backend') item=module}
		<li>
				<a href="?admin/module/{$module->get_module_name()}">
					<img src="{$module->get_icon_path()}" alt="{$module->get_module_name()} icon" /><br />
					{$module->get_module_title()}
				</a>
			</li>
		{/foreach}
	</ul>
	<br class="cb" />
</div>