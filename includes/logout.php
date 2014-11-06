<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

if(User::isConnected())
{
	User::logout();
}

header('Location: '.HOME_DIR);

?>