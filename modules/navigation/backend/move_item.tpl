<h1>Verplaats &#8220;{$this->item->title|escape}&#8221;</h1>
<div id="inner">
	<form action="{$this->url('admin', 'module', $this->get_module_name(), 'move_item', $this->item->id)}" method="post">
		<p>
			<label for="move">Verplaatsen <em>onder</em></label>
			<select name="move" id="move">
				{assign var=root value=$this->item->get_root()}
				<option value="{$root->id}">{$root->title|escape} (Hoofdniveau)</option>
				{foreach from=$root->get_children() item=item}
				{$this->set_current($item)}
				{$this->render('option')}
				{/foreach}
			</select>
		</p>
		<p>
			<label for="submit">&nbsp;</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>