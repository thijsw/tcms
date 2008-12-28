<h1>Link toevoegen</h1>
<div id="inner">
	<form action="{$this->get_edit_link()}" method="post">
		<p>
			<label for="intro">Module</label>
			<select name="intro">
				{foreach from=$rep->get_all_modules('backend') item=module}
				<option value="{$module->get_module_name()}">{$module->get_module_title()|escape}</option>
				{/foreach}
			</select>
		</p>
		<p>
			<label for="text">Item</label>
			<textarea cols="75" rows="30" name="text">{$this->item->text|escape:html}</textarea>
		</p>
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" name="title" value="{$this->item->title}" />
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