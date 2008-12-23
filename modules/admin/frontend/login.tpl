<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Website Beheer &ndash; Inloggen</title>
		<style type="text/css">
			{literal}
			body {
				font-family: Helvetica, Arial, sans-serif;
				background: #efefef;
				color: #000;
				font-size: 13px;
			}
			#wrapper {
				width: 30em;
				margin: 4em auto;
				padding: 2em;
				border: 5px solid #ccc;
				background: #fff;
			}
			h1 {
				margin: 0;
				font-size: 14px;
			}
			p {
				margin: 1em 0 1em 0;
			}
			label {
				margin: 0 0 .5em 0;
				width: 10em;
				display: block;
				font-weight: bold;
			}
			input {
				margin: 0 0 0 0;
				font-size: 13px;
				padding: .1em;
			}
			{/literal}
		</style>
		<link rel="stylesheet" href="{$this->get_css_link()}" type="text/css" media="screen" charset="utf-8" />
	</head>
	<body>
		<div id="wrapper">
			<form action="?admin/login" method="post">
				<h1>Website Beheer</h1>
				<p>Hier kunt u inloggen met uw persoonlijke gebruikersnaam en wachtwoord om deze site te beheren</p>
				<p>
					<label for="username">Gebruikersnaam</label>
					<input type="text" name="username" />
				</p>
				<p>
					<label for="password">Wachtwoord</label>
					<input type="password" name="password" />
				</p>
				<p>
					<label for="submit">&nbsp;</label>
					<input type="submit" name="submit" value="Inloggen &raquo;" />
				</p>
			</form>
		</div>
	</body>
</html>