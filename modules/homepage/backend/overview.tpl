<h1>Koppel pagina aan homepage</h1>
<div id="inner">
	<form action="{$this->url('admin', 'module', $this->get_module_name(), 'update_id')}" method="post">
		<p>Kies een pagina uit de lijst van pagina's die aan de homepage wordt gekoppeld, de inleiding van de pagina
			met eventuele foto's en opmaak verschijnt op de homepage met een link naar de volledige pagina.
		</p>
		<p>
			<label for="id">Pagina</label>
			<select name="id" id="id">
				{assign var=page value=$rep->load_backend('page')}
				{foreach from=$page->get_all_items() item=item}
				<option value="{$item->id}" {if $item->id eq $this->item->id}selected="selected"{/if}>{$item->title|escape}</option>
				{/foreach}
			</select>
		</p>
		<p>
			<label for="submit">&nbsp;</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>