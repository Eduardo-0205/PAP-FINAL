<?php 
	$db_name = 'mysql:host=localhost;dbname=pap_db';
	$user_name = 'root';
	$user_password = 'usbw';

	$conn = new PDO($db_name, $user_name, $user_password);

	if(!$conn){
		echo "not connected";
	}

	function unique_id(){
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charLength = strlen($chars);
		$randomString = '';
		for ($i=0; $i < 20; $i++) { 
			$randomString.=$chars[mt_rand(0, $charLength - 1)];
		}
		return $randomString;
	}

?>