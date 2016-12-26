<?php

include('../db.php');

// set_time_limit ( 0 );

$gallery = new Gallery();

$response = [];

$images = $gallery->getAll();

if ($images)

{

$response = $images;

http_response_code(200);

} 


else {

$response['error'] = 1;

$response['msg'] = "Ошибка! Что-то пошло не так! Попробуйте ещё раз позже.";

http_response_code(500);

}

exit( json_encode($response) );