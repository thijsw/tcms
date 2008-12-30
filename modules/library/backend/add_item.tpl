<h1>Map toevoegen</h1>
<div id="inner">
	<form action="{$this->url('admin', 'module', $this->get_module_name(), 'add_item', $this->id)}" method="post">
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" id="title" name="title" value="{$this->item->title}" />
		</p>
		<p>
			<label for="submit">&nbsp;</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>