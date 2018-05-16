<?php

require '../config.php';
session_start();

$translator = new Translator($_SESSION['language']);

unset($_SESSION['sqlid']);

header("Location: " . SITE_URL . "/index.php?msg[0]=success&msg[1]=" . $translator->getString('logoutsuccess'));