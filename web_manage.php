<?php

	/**
	 * [向客服端发送json格式的状态数据]
	 * @param  [array] $aAnswer [状态码与状态消息]
	 * @return [null]
	 */
	function sendAnswer($aAnswer)
	{
		echo json_encode($aAnswer);
	}

	//define('DEBUG', true);
	if (!defined('DEBUG'))
	{
		error_reporting(0);
	}
	if (!isset($_POST['ftp_host']))
	{
		exit();
	}

	$ftp_host = $_POST['ftp_host'];
	$ftp_port = intval($_POST['ftp_port']);
	$ftp_user = $_POST['ftp_user'];
	$ftp_pwd  = $_POST['ftp_pwd'];
	

	try
	{
		$conn = @ftp_connect($ftp_host, $ftp_port, 300);
		if ($conn == FALSE)
		{
			$aLoginResult['state'] = 1;
			$aLoginResult['msg'] = '无法连接FTP服务器';
			sendAnswer($aLoginResult);
			exit();
		}
		else
		{
			if (@ftp_login($conn ,$ftp_user, $ftp_pwd))
			{
				$aLoginResult['state'] = 0;
				$aLoginResult['msg'] = 'filemanage.php';
				
				//创建会话
				session_start();
				$_SESSION['ftp_login'] = true;

				//FTP信息写入cookie
				setcookie('ftp_cookie[0]', $ftp_host);
				setcookie('ftp_cookie[1]', $ftp_port);
				setcookie('ftp_cookie[2]', $ftp_user);
				setcookie('ftp_cookie[3]', $ftp_pwd);
				sendAnswer($aLoginResult);
				exit();
				/*
				$directory_root = ftp_pwd($conn);
 				$directory = ftp_nlist($conn, '');

 				foreach ($directory as $key => $value) 
 				{
    				echo "ftp://{$ftp_host}{$directory_root}/{$value}<br/>";
 				}
 				*/
			}
			else
			{
 				$aLoginResult['state'] = 2;
 				$aLoginResult['msg'] = '无法登陆该FTP用户';
 				sendAnswer($aLoginResult);
 				exit();
			}

			ftp_close($conn);
		}

	}
	catch(Exception $e)
	{
		throw new Exception();
		exit();
	}

?>
