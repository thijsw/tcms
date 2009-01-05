<div class="box">
	<h2>{$this->get_title()|escape}</h2>
	<p id="introduction"><strong>{$this->item->intro|escape}</strong></p>
	{$this->item->text|textile}
</div>