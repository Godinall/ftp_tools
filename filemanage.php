<!--
		Copyright © BadTudou, 2016
		All rights reserved

		Name	:	filenamege.php
		By		:	BadTudu
		Date	:	2016年3月18日13:54:05
		Note	:	FTP文件管理页面
-->
	<?php
		session_start();
		require_once('FTP.php');
		use badtudou\FTP as FTP;
		define('DEBUG', true);
		if (!defined('DEBUG'))
		{
			error_reporting(0);
		}
		
		//登录状态检查
		if ( !(isset($_SESSION['ftp_login']) && $_SESSION['ftp_login'] === true) )
		{
			header('Location: index.php');
			exit();
		}
		
		//读取cookie
		$aFTPInfo =  $_COOKIE['ftp_cookie'];
		
		$ftpManage = new FTP($aFTPInfo[0], $aFTPInfo[1], $aFTPInfo[2], $aFTPInfo[3]);
	?>
