<?php
error_reporting(0);
if (md5($_GET['password']) != file_get_contents('password.private.config')) {
	exit();
}
file_put_contents('password.private.config', md5($_GET['new']));