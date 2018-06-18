<?php

session_start();

define('PAGENAME', "profile");
define('THIS_SCRIPT', 'view_profile');

require '../config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);

$sqlid = (int) DatabaseHandler::escape_string($_GET['uid']);
$user = DatabaseHandler::getUserBySQLID($sqlid);
if($user != null)
{
	define('CUSTOM_TITLE', $translator->getString('title', array('pagename' => $user->getUsername() . ' ' . $translator->getString('profile'))));
	$page = '<div class="ProfileContainer">';
	$page .=        '<section class="UpperSection">';
	$page .=            '<div class="UpperSectionLeft">';
    $page .=                '<img class="avatar" src="' . $user->getAvatar() . '">';
    $page .=            '</div><!-- UpperSectionLeft -->';
    $page .=            '<div class="UpperSectionRight">';
	$page .=                    '<span id="DateJoined">' . $translator->getString('joined') . ' ' . date("F j, Y", $user->getJoindate()) . '</span>';
    $page .=                '<div class="UpperSectionRightStart">';
    $page .=                    '<div id="NameRole"><p id="role">' . $user->getRoleTxt() . '</p><h1 id="username" >' . $user->getUsername() . '</h1></div>';
    $page .=                '</div><!-- UpperSectionRightStart -->';
    $page .=                '<div class="UpperSectionRightEnd">';
    $page .=                    '<p id="motto">' . htmlspecialchars($user->getMotto()) . '</p>';
    $page .=                '</div><!-- UpperSectionRightEnd -->';
    $page .=            '</div><!-- UpperSectionRight-->';
    $page .=        '</section><!-- UpperSection -->';
    $page .=        '<div class="MainSection">';
    $page .=            '<p>' . $user->getNationality() . '</p>';
	$gender = $user->getGender();
	if ($gender==0) $gender=$translator->getString('gender0');
	if ($gender==1) $gender=$translator->getString('gender1');
	if ($gender==2) $gender=$translator->getString('gender2');
	$page .='<p>'. $gender .'</p>';
	if($user->getDescription() == '') $description = $translator->getString('emptydescription');
	$page .='<p>'. $user->getDescription() .'</p>';
    $page .=        '</div><!-- MainSection -->';
    $page .='</div><!-- ProfileContainer -->';
}
else
{
	$page = 'User not found';
}

PageDrawer::drawPage($page);

DatabaseHandler::close();