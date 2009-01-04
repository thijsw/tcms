{if $this->item->id}
	<h1>&#8220;{$this->item->title|escape}&#8221; bewerken</h1>
{else}
	<h1>Nieuwe column</h1>
{/if}
<div id="inner">
	<form action="{$this->get_edit_link()}" method="post">
		<input type="hidden" name="id" value="{$this->item->id}" />
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" name="title" value="{$this->item->title|escape:html}" />
		</p>
		<p>
			<label for="name">Auteur</label>
			<input type="text" id="name" name="name" value="{$this->item->name|escape:html}" />
		</p>
		<p>
			<label for="content">Inhoud</label>
			<textarea cols="75" rows="30" name="content">{$this->item->content|escape:html}</textarea>
		</p>
		<p>
			<label for="submit">Pagina opslaan</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>