<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="nl" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{$this->get_title()|escape} - Studenten Organisatie Groningen (SOG)</title>
	<link rel="stylesheet" href="{$this->get_css_link()}" type="text/css" media="screen" title="Main stylesheet" charset="utf-8" />
</head>
<body>
{assign var=navigation value=$rep->load_frontend('navigation')}
	<div id="wrapper">

		<div id="right">
			<div id="top">
				<ul class="navigation">
					{assign var=hoofdmenu value=$navigation->get_menu('hoofdmenu')}
					{foreach from=$hoofdmenu->get_children() item=item}
					<li {if $item->is_active()}class="selected"{/if}><a href="{$item->get_link()}">{$item->title|escape}</a></li>
					{/foreach}
				</ul>
			</div>
			
			<div id="bar">
				<ul>
					{foreach from=$navigation->get_breadcrumbs() item=bc name=bc}
					{if $smarty.foreach.bc.last}
						<li>{$bc->title|escape}</li>
					{else}
						<li><a href="{$bc->get_link()}">{$bc->title|escape}</a> &rsaquo;</li>
					{/if}
					{/foreach}
					</ul>
			</div>

			{$this->render('middle')}

		</div>

		<div id="left">
			<div id="logo">
				<h1><a href="">[logo hier]</a></h1>
			</div>

			<div class="box">
				{assign var=vereniging value=$navigation->get_menu('vereniging')}
				<h3>{$vereniging->title|escape}</h3>
				<ul class="menu">
					{$tpl->set('item', $vereniging)}
					{$this->render('menu-item')}
				</ul>
			</div>

			<div class="box">
				{assign var=fractie value=$navigation->get_menu('fractie')}
				<h3>{$fractie->title|escape}</h3>
				<ul class="menu">
					{$tpl->set('item', $fractie)}
					{$this->render('menu-item')}
				</ul>
			</div>
		</div>

		<div id="footer">
			<p>&copy; 2008 <a href="{$this->url()}">Studenten Organisatie Groningen</a> &middot; KvK 40023028 Groningen<br />Technische realisatie en vormgeving: <a href="http://thijs.wijnmaalen.name/">Thijs Wijnmaalen</a></p>
		</div>

	</div>

</body>
</html>