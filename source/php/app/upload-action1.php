<?php
$files =  $_FILES;
$data = $_POST;

define ("MAX_SIZE","2000");

$path = $_SERVER["DOCUMENT_ROOT"]. '/upload/';

$tmp_path = 'tmp';



// массив для ответа
$resp = ['msg' => '', 'error' => 0, 'src' => '']; 

foreach ($files['photo']["name"] as $name => $value) {

// if ( empty($files['photo']['tmp_name'][$name]) || !$files['photo']['size'] ) { 

// $resp['error'] = 1;

// $resp['msg'] = "Ошибка! Один из файлов не передан, попробуйте ещё раз.";

// die( json_encode($resp) );

// }


// $uploadfile = $path . basename($files['photo']['tmp_name'][$name]);

$filename = stripslashes($files['photo']['name'][$name]);
$size = filesize($$files['photo']['tmp_name'][$name]);


 // Массив допустимых значений типа файла
$types = array('jpeg', 'jpg');

 // Обработка запроса
// Проверяем тип файла

$ext = substr( $filename, strrpos($filename, ".") +1 );

	if (!in_array($ext, $types) ) {
		
		$resp['msg'] = 'Ошибка! Запрещённый тип файла!';

		$resp['error'] = 1;

		die(json_encode($resp));

	}

	 // Проверяем размер файла
	if ($size > (MAX_SIZE * 1024) )
	{ 

				$resp['error'] = 1;

		$resp['msg'] = 'Ошибка! Слишком большой размер файла!';

		die( json_encode($resp) );

	}

	$image_name= time(). "_" .$filename;

	$newname = "/upload/" . $image_name;

	 // Загрузка файла и вывод сообщения

	if ( !move_uploaded_file($files['photo']['tmp_name'][$name], $newname) ) {
		
		$resp['error'] = 1;
		$resp['msg'] = 'Ошибка! Что-то пошло не так.';
	}


	}

	$resp['msg'] = 'Файлы загружены!';
	$resp['error'] = 0;

	exit (json_encode($resp));






