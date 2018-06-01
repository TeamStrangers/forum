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
	$page = '<div class="container"><img id="mainInfoLeft" src="' . $user->getAvatar() . '"><div id="mainInfoRight">';
    $page .= '<span>' . $translator->getString('joined') . ' ' . date("F j, Y", $user->getJoindate()) . '</span>';
    $page .= '<p>' . $user->getUsername() . '</p>';
    $page .= '<p>' . $user->getRoleTxt() . '</p>';
    $page .= '<p>' . htmlspecialchars($user->getMotto()) . '</p>';
	$page .= '</div></div>';
	$description = $user->getDescription();
	if($user->getDescription() == '') $description = $translator->getString('emptydescription');
	$gender = $user->getGender();
    $page .= '<div class="container"><span class="title">' . $translator->getString('aboutme') . '</span><div class="description">' . htmlspecialchars($description) . '</span></div><span class="gender">' . $user->getGender() . '</span></div>';
    $page .= '<div class="container"></div>';
/*	$page = '<div class="ProfileContainer">';
	$page .=    '<div class="Wrap">';
	$page .=        '<section class="UpperSection">';
	$page .=            '<div class="UpperSectionLeftStart">';
    $page .=                '<img class="avatar" src="' . $user->getAvatar() . '">';
    $page .=            '</div><!-- UpperSectionLeftStart -->';
    $page .=            '<div class="UpperSectionRightStart">';
    $page .=                '<div id="NameRole"><p id="role">' . $user->getRoleTxt() . '</p><h1 id="username" >' . $user->getUsername() . '</h1></div>';
    $page .=            '</div><!-- UpperSectionRightStart -->';
    $page .=            '<div class="UpperSectionRightEnd">';
    $page .=                '<div id="Status"><h4>Status</h4><p id="motto">' . $user->getMotto() . '</p></div>';
    $page .=            '</div><!-- UpperSectionRightEnd -->';
    $page .=        '</section><!-- UpperSection -->';
    $page .=        '<div class="MainSection">';
    $page .=            '<p>' . $user->getNationality() . '</p>';
    if($user->getDescription() != "No description") {
        $page .=        '<p>' . $user->getDescription() . '</p>';
    }
    $page .=        '</div><!-- MainSection -->';
    $page .=    '</div><!-- Wrap -->';
    $page .='</div><!-- ProfileContainer -->';*/
}
else
{
	$page = 'User not found';
}

PageDrawer::drawPage($page);

DatabaseHandler::close();