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

 $path_to_thumbs = "upload/mini/";

 $miniName =   $path_to_thumbs . $filename;

  	 // Загрузка файла и вывод сообщения

	if ( !move_uploaded_file($file['tmp_name'], $path .$filename ) ) {
		
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



array_push($uploaded, $miniName); 

}

}
$resp['uploaded'] = $uploaded;

	$resp['msg'] = 'Все файлы успешно загружены!';
	$resp['error'] = 0;

	exit (json_encode($resp));
	






