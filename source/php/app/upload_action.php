<?php
$files =  $_FILES;
// $data = $_POST;

define ("MAX_SIZE","2000");

$path = $_SERVER["DOCUMENT_ROOT"]. '/upload/';

$tmp_path = 'tmp';

// массив для ответа
$resp = ['msg' => '', 'error' => 0, 'uploaded' => array('src' => [])]; 

// if ( empty($data['photo'])  ) { 

// $resp['error'] = 1;

// $resp['msg'] = "Ошибка! Один из файлов не передан, попробуйте ещё раз.";

// die( json_encode($resp) );

// }

$uploaded = [];


foreach ($_FILES as $file) {


$filename = $file['name'];
$size = filesize($file['tmp_name']);

 // Массив допустимых значений типа файла
$types = array('jpeg', 'jpg');

 // Обработка запроса
// Проверяем тип файла

$ext = substr( $filename, strrpos($filename, ".") +1 );

	if (!in_array($ext, $types) ) {
		
		$resp['msg'] = 'Ошибка! Можно загружать только файлы форматов JPEG и JPG!';

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

	// $image_name= basename($filename);

 $newname = "upload/" . $filename;

	 // Загрузка файла и вывод сообщения

	if ( !move_uploaded_file($file['tmp_name'], $path .$filename ) ) {
		
		$resp['error'] = 1;
		$resp['msg'] = 'Ошибка! Не удалось загрузить изображения!';

		exit (json_encode($resp));
	}

else  {

array_push($uploaded, $newname); 

}

}
$resp['uploaded'] = $uploaded;

	$resp['msg'] = 'Все файлы успешно загружены!';
	$resp['error'] = 0;

	exit (json_encode($resp));
	






