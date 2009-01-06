<h1>Menu-item bewerken</h1>
<div id="inner">
	<form action="{$this->url('admin', 'module', $this->get_module_name(), 'edit', $this->item->id)}" method="post">
		<input type="hidden" name="id" value="{$this->item->id}" />
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" id="title" name="title" value="{$this->item->title}" />
		</p>
		<p>
			<label for="submit">Pagina opslaan</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>