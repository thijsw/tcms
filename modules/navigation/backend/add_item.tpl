<h1>Link toevoegen</h1>
<div id="inner">
	<form action="{$this->url('admin', 'module', $this->get_module_name(), 'add_item', $this->id)}" method="post">
		<p>
			<label for="module">Module</label>
			<select name="module" id="module">
				<option value="-1">&ndash; Kies een module &ndash;</option>
				{foreach from=$rep->get_all_modules('backend') item=module}
				<option value="{$module->get_module_name()}">{$module->get_module_title()|escape}</option>
				{/foreach}
			</select>
		</p>
		<p>
			<label for="item">Item</label>
			<select name="item" disabled="disabled" id="item"><option value="-1">&ndash; Geen items gevonden &ndash;</option></select>
		</p>
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" id="title" name="title" value="{$this->item->title}" />
		</p>
		<p>
			<label for="enabled">Zichtbaar</label>
			<input type="checkbox" name="enabled" {if $this->item->enabled}checked="checked"{/if} />
		</p>
		<p>
			<label for="submit">Pagina opslaan</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>