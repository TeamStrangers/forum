<?php

require '../config.php';
session_start();

$translator = new Translator($_SESSION['language']);

unset($_SESSION['sqlid']);

$fromsite = SITE_URL . '/index.php';
if(isset($_POST['fromsite'])) $fromsite = $_REQUEST['fromsite'];

header("Location: " . $fromsite);