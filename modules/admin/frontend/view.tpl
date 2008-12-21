<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Website Beheer</title>
		<link rel="stylesheet" href="{$this->module->get_css_link('backend')}" type="text/css" media="screen" />
	</head>
	<body>
		<div id="wrapper">

			<div id="header">
				<p>
					<strong>Thijs Wijnmaalen</strong> (<a href="?admin/logout">Uitloggen</a>)
					&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/">Naar website&nbsp;&raquo;</a></p>
				<h1><a href="?{$this->get_module_name()}">Website Beheer</a></h1>
			</div>

			<div id="main">
				<p id="breadcrumbs"><a href="?admin">Beheer</a>{if $this->module->get_module_name() neq 'admin'} &raquo; <a href="?admin/module/{$this->module->get_module_name()}">{$this->module->get_module_title()|escape}</a>{/if}</p>
				<div id="contents">
					{if $this->method}
						{assign var=method value=$this->method}
						{$this->module->$method($this->param)}
					{else}
						{$this->render('overview')}
					{/if}
				</div>
			</div>

		</div>
	</body>
</html>