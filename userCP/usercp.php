<?php

session_start();

define('PAGENAME', "account_settings");
define('THIS_SCRIPT', 'usercp');

require '../config.php';

DatabaseHandler::connect();

global $translator, $current_user;
$page = '';
$additions = array();

if($current_user != null)
{
	$additions['custom_menu'] = array();
	$additions['custom_menu'][$translator->getString('change_profile')] = '/userCP/usercp.php?page=changeprofile';
	$additions['custom_menu'][$translator->getString('change_password')] = '/userCP/usercp.php?page=changepw';
	$additions['custom_menu'][$translator->getString('change_email')] = '/userCP/usercp.php?page=changemail';
	$additions['custom_menu'][$translator->getString('change_avatar')] = '/userCP/usercp.php?page=changeavatar';

	if(isset($_REQUEST['page']))
	{
		if($_REQUEST['page'] == 'changeprofile')
		{
			$page .= '';
		}
		else if($_REQUEST['page'] == 'changepw')
		{
			if(isset($_POST['curr-passwd']) && isset($_POST['new-passwd']) && isset($_POST['new-passwd2']))
			{
				$current_pass = hash('sha256', $salt . DatabaseHandler::escape_string($_POST['curr-passwd']));
				if(strcasecmp($current_user->getPassword(), $current_pass) == 0)
				{
					if(strcasecmp($_POST['new-passwd'], $_POST['new-passwd2']) == 0)
					{
						$new_pass = hash('sha256', $salt . DatabaseHandler::escape_string($_POST['new-passwd']));
						$current_user->setPassword($new_pass);
						DatabaseHandler::saveUser($current_user);
					}
				}
			}
			else
			{
				$page .= '<form method="POST">';
				$page .= '<input type="password" name="curr-passwd" placeholder="'.$translator->getString('password4').'" required><br>';
				$page .= '<input type="password" name="new-passwd" placeholder="'.$translator->getString('password3').'" required><br>';
				$page .= '<input type="password" name="new-passwd2" placeholder="'.$translator->getString('password2').'" required><br>';
				$page .= '<input type="submit" value="'.$translator->getString('change_password').'"><br>';
				$page .= '</form>';
			}
		}
		else if($_REQUEST['page'] == 'changemail')
		{
			if(isset($_POST['new-email']))
			{
				$new_email = DatabaseHandler::escape_string($_POST['new-email']);
				$current_user->setEmail($new_email);
				DatabaseHandler::saveUser($current_user);
			}
			else
			{
				$page .= '<form method="POST">';
				$page .= '<input type="email" name="new-email" placeholder="'.$translator->getString('email2').'" required><br>';
				$page .= '<input type="submit" value="'.$translator->getString('change_email').'"><br>';
				$page .= '</form>';
			}
		}
		else if($_REQUEST['page'] == 'changeavatar')
		{
		}
	}
	else PageDrawer::redirectTo('/userCP/usercp.php?page=changeprofile');
}
else
{
	PageDrawer::redirectToIndex();
}


PageDrawer::drawPage($page, $additions);

DatabaseHandler::close();