<?php

require_once 'functionClasses/PageDrawer.php';
require_once 'functionClasses/DatabaseHandler.php';
require_once 'translations/Translator.php';

$mysql['hostname'] = 'localhost';
$mysql['username'] = 'discussr';
$mysql['password'] = 'discussr';
$mysql['database'] = 'discussr';
$mysql['dbprefix'] = 'discussr_';

$salt = 'laumdfhads';
