<?php
include('../db.php');

set_time_limit ( 0 );

$method = strtolower( $_SERVER['REQUEST_METHOD'] );

$gallery = new Gallery();

$request = explode('/', substr($_SERVER['PATH_INFO'], 1));

$id = array_shift($request);

if ($gallery->remove($id)) {

$response['error'] = 0;

$response['msg'] = "Изображение успешно удалено!";

http_response_code(200);

}


else {

$response['error'] = 1;

$response['msg'] = "Ошибка! Что-то пошло не так! Попробуйте ещё раз позже.";

http_response_code(500);


}

exit( json_encode($response) );