<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Website Beheer</title>
		<link rel="stylesheet" href="{$this->get_css_link()}" type="text/css" media="screen" />
	</head>
	<body>
		<div id="wrapper">
			
			<div id="header">
				<p>Ingelogd als Thijs Wijnmaalen</p>
				<h1><a href="?">Website Beheer</a></h1>
			</div>

			<!-- Optional menu area -->
			<!--
			<div id="menu"></div>
			-->

			<div id="main">
				<p>Home &raquo; Library Module</p>
				<div id="contents">
					{include file=modules.tpl this=$this}
				</div>
			</div>

		</div>
	</body>
</html>