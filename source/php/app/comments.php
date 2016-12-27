<?php
require("../db.php");
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

$comments =  new Comments();

if ($method == 'post') { 

$post = json_decode(file_get_contents('php://input'), true); 

if ( $comments->add($post['content'], $post['img_id']) ) {

http_response_code(200);

$response['id'] = $comments->getId();
$response['error'] = 0;
$response['msg'] = 'Комментарий успешно добавлен!';

}

else {

http_response_code(500);

$response['error'] = 'Ошибка! Что-то пошло не так! Попробуйте повторить данное действие позже или обратитесь к разработчику.';

}

}

// Удаление комментариев
else if ( $method == 'delete' ) { 

$request = explode('/', substr($_SERVER['PATH_INFO'], 1));
$id = array_shift($request);


if ( $comments->remove($id) ) {

http_response_code(200);

$response['error'] = 0;
$response['msg'] = 'Комментарий успешно удалён!';

}

else {

http_response_code(500);

$response['error'] = 'Ошибка! Что-то пошло не так! Попробуйте повторить данное действие позже или обратитесь к разработчику.';

}

}


else if ( $method == 'put' || $method == 'patch' ) { 

$input = json_decode(file_get_contents('php://input'), true); 

$request = explode('/', substr($_SERVER['PATH_INFO'], 1));
$id = array_shift($request);

if ( $comments->edit($id, $input['content']) ) {

http_response_code(200);

$response['error'] = 0;
$response['msg'] = 'Комментарий успешно изменён!';

}

else {

http_response_code(500);

$response['error'] = 'Ошибка! Что-то пошло не так! Попробуйте повторить данное действие позже или обратитесь к разработчику.';

}


}

header('Content-Type: application/json');

$response = json_encode( $response ); 

exit( $response );
