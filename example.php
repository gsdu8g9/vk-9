<?php
//Подключаем класс
require 'vkapi.class.php';

//Создаем объект
$vk = new VkApi( 'NUMBER APP','SECRET KEY','REDIRECT URI' );


/* --------- Логинемся ---------- */

//Если нет ни в сессии не в GET, то пусть логинится
if( empty( $_SESSION['token'] ) && empty( $_GET['code'] ) ){
	header( 'Location: ' . $vk->goAuth() );
	exit();
}

//Если нет в сессии,но ЕСТЬ GET['code'], то получаем токен
if( empty( $_SESSION['token'] ) && isset( $_GET['code'] ) ){
	$resp = $vk->getToken( $_GET['code'] );

	if( isset( $resp['error'] ) ){
		echo 'Error: ' . $resp['error_description']; //Если ошибка, выводим описание ошибки

	}elseif( isset( $resp['access_token'] ) ){
		echo 'Success: ' . $resp['access_token']; //Если все ок, выводим токен и сейвим его в сессию
		$_SESSION['token'] = $resp['access_token'];
	}
}



/* --------- К примеру добавить трек ---------- */

$params = array(
	'audio_id'  => '23260363',
	'owner_id'	=> '90522656'
);
$resp = $vk->goMethod( 'audio.add', $params, $_SESSION['token'] );


echo 'Добавлена: audio' . $params['audio_id'] . '_' . $params['owner_id'] . '<br/>';

/* ------------------- */

?>