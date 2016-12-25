<?php

require_once "config.php";


$host = DB_HOST;
$dbname = DB_NAME;
$password = DB_PASSWORD;
$user = DB_USER;
$dsn = "mysql:host=$host;dbname=$dbname";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);



interface GalleryInterface {

public function add($src,$mini);
public function remove($id);
public function edit( $title = "", $description = "" );

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


$stmt = $this->pdo->prepare('DELETE FROM `gal_images` WHERE id = :id');

$stmt->bindParam(':id', $id);

if ( $stmt->execute() )  return true;

else return false;

			}

public function edit( $title = "", $description = "" )
{


}



}

