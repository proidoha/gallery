<?php
require("../db.php");
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

$comments =  new Comments();

if ($method == 'post') { 

$post = json_decode(file_get_contents('php://input'), true); 

// $comments->add($post['content'], $post['img_id']);

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

exit( json_encode($response) );

}


else if ( $method == 'delete' ) { 

// $input = json_decode(file_get_contents('php://input'), true); 


$request = explode('/', substr($_SERVER['PATH_INFO'], 1));
$id = array_shift($request);


$stmt = $pdo->prepare('DELETE FROM `comments` WHERE id = :id');

$stmt->bindParam(':id', $id);

if ( $stmt->execute() ) {

	$response['error'] = 0;

$response['msg'] = "Ваш комментарий успешно удалён!";

http_response_code(200);


} 

else {

	http_response_code(500);

$response['error'] = "Ошибка! Что-то пошло не так! Попробуйте позже.";

}

header('Content-Type: application/json');

$response = json_encode( $response ); 

exit( $response );

}


else if ( $method == 'put' || $method == 'patch' ) { 

$input = json_decode(file_get_contents('php://input'), true); 


$request = explode('/', substr($_SERVER['PATH_INFO'], 1));
$id = array_shift($request);


$stmt = $pdo->prepare('UPDATE `comments` SET content = :content, author = :author WHERE id = :id');

// $stmt->bindParam(':id', $id);

$arr =  array( 'content' => $input['content'], 'author' => $input['author'], 'id' => $id );

if ( $stmt->execute( $arr ) ) {

$response['error'] = 0;

$response['msg'] = "Ваш комментарий успешно изменён!";

http_response_code(200);


} 

else {

	http_response_code(500);

$response['error'] = "Ошибка! Что-то пошло не так! Попробуйте позже.";

}

header('Content-Type: application/json');

$response = json_encode( $response  ); 

exit( $response );

}