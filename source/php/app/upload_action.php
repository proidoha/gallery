<?php
$files =  $_FILES;

include('../db.php');

set_time_limit ( 0 );

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

$gallery = new Gallery();

$i = 0;


foreach ($_FILES as $file) {


$filename = basename($file['name']);
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


	// Убираем пробельные символы

$correctfilename = str_replace(' ', '',  $filename);

 $newname = "upload/" . $correctfilename;

 $path_to_thumbs = "upload/mini/";

 $miniName =   $path_to_thumbs . $correctfilename;

  	 // Загрузка файла и вывод сообщения


	if ( !copy($file['tmp_name'], $path .$correctfilename ) ) {
		
		$resp['error'] = 1;
		$resp['msg'] = 'Ошибка! Не удалось загрузить изображения!';

		exit (json_encode($resp));
	}

else  {

// 	 $im = imagecreatefromjpeg( $_SERVER["DOCUMENT_ROOT"]."/". $newname);

// $ox = imagesx($im);
//   $oy = imagesy($im);
  
//   $nx = 340;
//   $ny = floor($oy * ($nx / $ox));
//   $y = 282;
  
//   $nm = imagecreatetruecolor($nx, 282);
  
//   imagecopyresized($nm, $im, 0,0,0,0,$nx,$y,$ox,$oy);

//   imagejpeg($nm, $_SERVER["DOCUMENT_ROOT"]."/". $path_to_thumbs . $filename);



$nw = 340;
$nh = 282;
$source = $_SERVER["DOCUMENT_ROOT"]."/". $newname;

$imsize = getimagesize($source);
$w = $imsize[0];
$h = $imsize[1];
$simg = imagecreatefromjpeg($source);
$dimg = imagecreatetruecolor($nw, $nh);

$wm = $w/$nw;
$hm = $h/$nh;
$h_height = $nh/2;
$w_height = $nw/2;

  if($w> $h) {
            $adjusted_width = $w / $hm;
            $half_width = $adjusted_width / 2;
            $int_width = $half_width - $w_height;
            imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
        } elseif(($w <$h) || ($w == $h)) {
            $adjusted_height = $h / $wm;
            $half_height = $adjusted_height / 2;
            $int_height = $half_height - $h_height;
 
            imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
        } else {
            imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
        }
            imagejpeg( $dimg, $_SERVER["DOCUMENT_ROOT"]. '/'. $miniName,100);



$uploaded[$i]['mini'] = $miniName; 

$uploaded[$i]['src'] = $newname;

if ( !$gallery->add($newname, $miniName) ) { 

$resp['error'] = 1;

	$resp['msg'] = "Ошибка! Что-то пошло не так! Попробуйте позже.";

	exit (json_encode($resp));

}

if ($gallery->getId()) $uploaded[$i]['id'] = $gallery->getId();

else {

$resp['error'] = 1;

$resp['msg'] = 'Ошибка! Не удалось добавить изображение в базу! Попробуйте ещё раз!';

exit (json_encode($resp));


}



}

$i++;

}

// $resp['uploaded'] = [];

http_response_code(200);

$resp['uploaded'] = $uploaded;

	$resp['msg'] = 'Все файлы успешно загружены!';
	$resp['error'] = 0;

	exit (json_encode($resp));
	






