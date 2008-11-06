{if $this->page->id}
	<h1>&#8220;{$this->page->title|escape}&#8221; bewerken</h1>
{else}
	<h1>Nieuwe pagina</h1>
{/if}
<div id="inner">
	<form action="?admin/module/page/{if $this->page->id}edit/{$this->page->id}{else}create{/if}" method="post">
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" name="title" value="{$this->page->title}" />
		</p>
		<p>
			<label for="name">Naam in adresbalk</label>
			<input type="text" size="40" name="name" disabled="disabled" value="{$this->page->name}" />
		</p>
		<p>
			<label for="text">Inhoud</label>
			<textarea cols="75" rows="30" name="text">{$this->page->text|escape:html}</textarea>
		</p>
		<p>
			<label for="enabled">Gepubliceerd</label>
			<input type="checkbox" name="enabled" {if $this->page->enabled}checked="checked"{/if} />
		</p>
		<p>
			<label for="submit">Pagina opslaan</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>