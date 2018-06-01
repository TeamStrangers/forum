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
	$additions['custom_menu0'] = array();
	$additions['custom_menu0'][$translator->getString('change_profile')] = '/userCP/usercp.php?page=changeprofile';
	$additions['custom_menu0'][$translator->getString('change_password')] = '/userCP/usercp.php?page=changepw';
	$additions['custom_menu0'][$translator->getString('change_email')] = '/userCP/usercp.php?page=changemail';
	$additions['custom_menu0'][$translator->getString('change_username')] = '/userCP/usercp.php?page=changename';
	$additions['custom_menu0'][$translator->getString('change_avatar')] = '/userCP/usercp.php?page=changeavatar';

	if(isset($_REQUEST['page']))
	{
		if($_REQUEST['page'] == 'changeprofile')
		{
			if(isset($_POST['gender']) || isset($_POST['description']) || isset($_POST['motto']) || isset($_POST['homepage']) || isset($_POST['nationality']) || isset($_POST['timezone']))
			{
				if(isset($_POST['gender'])) $current_user->setGender(DatabaseHandler::escape_string($_POST['gender']));
				if(isset($_POST['description'])) $current_user->setDescription(DatabaseHandler::escape_string($_POST['description']));
				if(isset($_POST['motto'])) $current_user->setMotto(DatabaseHandler::escape_string($_POST['motto']));
				if(isset($_POST['homepage'])) $current_user->setHomepage(DatabaseHandler::escape_string($_POST['homepage']));
				if(isset($_POST['nationality'])) $current_user->setNationality(DatabaseHandler::escape_string($_POST['nationality']));
				if(isset($_POST['timezone'])) $current_user->setTimezone(DatabaseHandler::escape_string($_POST['timezone']));

				DatabaseHandler::saveUser($current_user);

				PageDrawer::redirectTo('/userCP/usercp.php?page=changeprofile');
			}
			else
			{
				$page .= '<form method="POST">';
				$page .= '<select name="gender">';
				$page .= '<option value="0"' . ($current_user->getGender()==0?' selected':'') . '>' . $translator->getString('changeprofile_gender0') . '</option>';
				$page .= '<option value="1"' . ($current_user->getGender()==1?' selected':'') . '>' . $translator->getString('changeprofile_gender1') . '</option>';
				$page .= '<option value="2"' . ($current_user->getGender()==2?' selected':'') . '>' . $translator->getString('changeprofile_gender2') . '</option>';
				$page .= '</select><br>';
				$page .= '<textarea name="description" placeholder="'.$translator->getString('changeprofile_description').'">' . $current_user->getDescription() . '</textarea><br>';
				$page .= '<textarea name="motto" placeholder="'.$translator->getString('changeprofile_motto').'">' . $current_user->getMotto() . '</textarea><br>';
				$page .= '<input type="text" name="homepage" placeholder="'.$translator->getString('changeprofile_homepage').'" value="' . $current_user->getHomepage() . '"><br>';
				$page .= '<input type="text" name="nationality" placeholder="'.$translator->getString('changeprofile_nationality').'" value="' . $current_user->getNationality() . '"><br>';
				$page .= '<input type="text" name="timezone" placeholder="'.$translator->getString('changeprofile_timezone').'" value="' . $current_user->getTimezone() . '"><br>';
				$page .= '<input type="submit" value="'.$translator->getString('save_profile').'"><br>';
				$page .= '</form>';
			}
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
				PageDrawer::redirectTo('/userCP/usercp.php?page=changepw');
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
				$emailFree = true;
				foreach(DatabaseHandler::getAllUsers() as $user)
				{
					if(strcasecmp($user->getEmail(), $email) == 0)
					{
						$emailFree = false;
					}
				}

				if($emailFree == true)
				{
					$new_email = DatabaseHandler::escape_string($_POST['new-email']);
					$current_user->setEmail($new_email);
					DatabaseHandler::saveUser($current_user);
				}
				PageDrawer::redirectTo('/userCP/usercp.php?page=changemail');
			}
			else
			{
				$page .= '<form method="POST">';
				$page .= '<input type="email" name="new-email" placeholder="'.$translator->getString('email2').'" required><br>';
				$page .= '<input type="submit" value="'.$translator->getString('change_email').'"><br>';
				$page .= '</form>';
			}
		}
		else if($_REQUEST['page'] == 'changename')
		{
			if(isset($_POST['new-username']))
			{
				$usernameFree = true;
				foreach(DatabaseHandler::getAllUsers() as $user)
				{
					if(strcasecmp($user->getUsername(), $username) == 0)
					{
						$usernameFree = false;
					}
				}

				if($usernameFree == true)
				{
					$new_username = DatabaseHandler::escape_string($_POST['new-username']);
					$current_user->setUsername($new_username);
					DatabaseHandler::saveUser($current_user);
				}
				PageDrawer::redirectTo('/userCP/usercp.php?page=changename');
			}
			else
			{
				$page .= '<form method="POST">';
				$page .= '<input type="text" name="new-username" placeholder="'.$translator->getString('username2').'" required><br>';
				$page .= '<input type="submit" value="'.$translator->getString('change_username').'"><br>';
				$page .= '</form>';
			}
		}
		else if($_REQUEST['page'] == 'changeavatar')
		{
			if(isset($_POST['avatar']))
			{
				$email = md5($_POST['avatar']);
				$avatarurl = 'http://www.gravatar.com/avatar/' . $email . '?s=200';
				$current_user->setAvatar($avatarurl);
				DatabaseHandler::saveUser($current_user);
				PageDrawer::redirectTo('/userCP/usercp.php?page=changeavatar');
			}
			else
			{
				$page .= '<form method="POST">';
				$page .= '<input type="email" name="avatar" placeholder="'.$translator->getString('gravatar_email').'"><br>';
				$page .= '<input type="submit" value="'.$translator->getString('change_avatar').'"><br>';
				$page .= '</form>';
			}
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