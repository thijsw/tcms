<h1>{$this->get_title()|escape}</h1>
<div id="inner">
	<table>
		<thead>
			<tr>
				<th>Bestandsnaam</th>
				<th>Titel</th>
				<th>Bestandsgrootte</th>
				<th>Ge&uuml;pload door</th>
				<th>Opties</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$this->contents item=file}
		{assign var=author value=$file->get_author()}
			<tr>
				<td><a href="{$this->url($this->get_module_name(), 'download', $file->id)}">{$file->name|escape}</a></td>
				<td><a href="{$this->url('admin', 'module', $this->get_module_name(), 'edit', $file->id)}">{$file->title|escape}</a></td>
				<td>{$file->get_human_readable_filesize()}</td>
				<td>{$author->name_first|escape} {$author->name_last|escape}</td>
				<td>[delete-link]</td>
			</tr>
			{foreachelse}
			<tr>
				<td colspan="5" style="text-align: center; padding: 2em;">
					<em>Er bevinden zich geen bestanden in deze map</em>
				</td>
			</tr>
			{/foreach}
			<tr>
				<td colspan="5"><img src="images/icons/add.png" /> <a href="{$this->url('admin', 'module', $this->get_module_name(), 'upload_file', $this->id)}"><strong>Bestand uploaden in deze map &raquo;</strong></a></td>
			</tr>
		</tbody>
	</table>
</div>