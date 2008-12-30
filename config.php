<?php

// Global configuration

define ('TCMS_PATH', '/Users/thijswijnmaalen/Sites/tcms');

$__default_module = 'homepage';
$__default_method = 'index';
$__modules_path   = TCMS_PATH . '/modules';
$__uploads_path   = TCMS_PATH . '/uploads';
$__module_file    = $__modules_path . '/%s/%s.php'; // modulename/frontend|backend.php
$__package_file   = $__modules_path . '/%s/package.xml';
$__mod_rewrite    = false;

?>