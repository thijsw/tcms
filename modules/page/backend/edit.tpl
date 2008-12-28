{if $this->item->id}
	<h1>&#8220;{$this->item->title|escape}&#8221; bewerken</h1>
{else}
	<h1>Nieuwe pagina</h1>
{/if}
<div id="inner">
	<form action="{$this->get_edit_link()}" method="post">
		<input type="hidden" name="id" value="{$this->item->id}" />
		<input type="hidden" name="author" value="{$this->item->author}" />
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" name="title" value="{$this->item->title}" />
		</p>
		<p>
			<label for="intro">Intro</label>
			<textarea cols="75" rows="5" name="intro">{$this->item->intro|escape:html}</textarea>
		</p>
		<p>
			<label for="text">Inhoud</label>
			<textarea cols="75" rows="30" name="text">{$this->item->text|escape:html}</textarea>
		</p>
		<p>
			<label for="enabled">Gepubliceerd</label>
			<input type="checkbox" name="enabled" {if $this->item->enabled}checked="checked"{/if} />
		</p>
		<p>
			<label for="submit">Pagina opslaan</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>