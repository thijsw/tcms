{if $this->item->id}
	<h1>&#8220;{$this->item->title|escape}&#8221; bewerken</h1>
{else}
	<h1>Media toevoegen</h1>
{/if}
<div id="inner">
	<form action="{$this->get_edit_link()}" method="post" enctype="mulipart/form-data">
		<input type="hidden" name="id" value="{$this->item->id}" />
		<input type="hidden" name="author" value="{$this->item->author}" />
		<p>
			<label for="title">Titel</label>
			<input type="text" size="40" name="title" value="{$this->item->title}" />
		</p>
		<p>
			<label for="class">Media</label>
			<select name="class">
				<option value="Library_Image">Afbeelding</option>
			</select>
		</p>
		<p>
			<label for="upload">Upload bestand</label>
			<input type="file" name="upload" />
		</p>
		<p>
			<label for="submit">&nbsp;</label>
			<input type="submit" value="Opslaan" />
		</p>
	</form>
</div>