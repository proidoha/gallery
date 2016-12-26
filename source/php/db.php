<?php

require_once "config.php";

interface GalleryInterface {

public function add($src,$mini);
public function remove($id);
public function getAll($id, $encode);
public function getImg($id);

}


// Класс для работы с изображениями

class Gallery implements GalleryInterface {

// id последнего созданного ресурса
public $last_id = false;
private $pdo;

public function __construct () {

$host = DB_HOST;
$dbname = DB_NAME;
$password = DB_PASSWORD;
$user = DB_USER;
$dsn = "mysql:host=$host;dbname=$dbname";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

$this->pdo = new PDO($dsn, $user, $password, $opt);

}


public function add ($src, $mini) {

// $this->pdo->prepare("SELECT COUNT(*) FROM `gal_images` WHERE src = ? OR mini = ");

	$stmt = $this->pdo->prepare('INSERT INTO `gal_images` (src, mini) VALUES (?,?)');

$arr = array( $src, $mini );


if ( $stmt->execute( $arr ) ) {

$this->last_id = $this->pdo->lastInsertId();

return true;
}

else return false;

			}


			public function getId() {

return $this->last_id;

			}


public function remove($id) {
// Получаем информацию об изображении для удаления файла
$data = $this->getImg($id);

if (!$data) return false;

$stmt = $this->pdo->prepare('DELETE FROM `gal_images` WHERE id = :id');

$stmt->bindParam(':id', $id);

if ( $stmt->execute() )   { 

$src = $_SERVER['DOCUMENT_ROOT'] . '/'. $data['src'];
$mini = $_SERVER['DOCUMENT_ROOT'] . '/'.$data['mini'];

if (file_exists($src)) unlink($src);

if (file_exists($mini)) unlink($mini);

return true;

}

else return false;

			}

public function edit( $title = "", $description = "" )
{


}


public function getAll($id = null, $encode = false) {

	$stmt = $this->pdo->prepare("SELECT * FROM `gal_images`");

if ($stmt->execute())
{
 return $stmt->fetchAll();
}

else return false;

}

public function getImg($id) {

	$stmt = $this->pdo->prepare("SELECT * FROM `gal_images` WHERE id = ?");

if ($stmt->execute( array($id) ) )
{
 return $stmt->fetch();
}

else return false;

}



}

class Comments extends Gallery {

// id последнего созданного ресурса
public $last_id = false;
private $pdo;


function __construct () {

$host = DB_HOST;
$dbname = DB_NAME;
$password = DB_PASSWORD;
$user = DB_USER;
$dsn = "mysql:host=$host;dbname=$dbname";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

$this->pdo = new PDO($dsn, $user, $password, $opt);

}

public function add ($content, $img_id) {

	$stmt = $this->pdo->prepare('INSERT INTO `gal_comments` (content, img_id) VALUES (?, ?)');

$arr = [$content, $img_id];


if ( $stmt->execute( $arr ) ) {

$this->last_id = $this->pdo->lastInsertId();

return true;
}

else return false;

			}


			public function getAll($img_id, $encode) {

	$stmt = $this->pdo->prepare("SELECT * FROM `gal_comments` WHERE img_id = ?");

if ($stmt->execute( array($img_id) ) )
{

$comments =  $stmt->fetchAll();

	$comments =  ($encode) ?  json_encode($comments) : $comments;

	return $comments;
 
}

else return false;

}


			public function getId() {

return $this->last_id;

			}

public function remove($id) {

$stmt = $this->pdo->prepare('DELETE FROM `gal_comments` WHERE id = :id');

$stmt->bindParam(':id', $id);

if ( $stmt->execute() )   { 

return true;

}

else return false;

			}


			public function edit( $id, $content )
{


$stmt = $this->pdo->prepare('UPDATE `gal_comments` SET content = :content  WHERE id = :id');

$stmt->bindParam(':id', $id);
$stmt->bindParam(':content', $content );

if ( $stmt->execute() )   { 

return true;

}

else return false;


}


}

