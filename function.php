<?php



define('DB_HOST', 'localhost');
define('DB_USER', 'ioanas');
define('DB_PASS', '123456');
define('DB_DBNM', 'ioanas');




/**
 * Creem o conexiune catre baza de date
 */
// creem o variabila globala pentru a tine conexiunea si pentru a o folosi peste tot
global $db;

function db_connect() {

	global $db;

	$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DBNM);
	if (!$db) {

		/**
		 * Daca nu exista sau daca nu ne conectam dam eroare si iesim
		 */
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

}
db_connect();
/**
 * incepem conexiunea
 */



global $dictionar;

$dictionar = [

	'users' => 'users',
	
];




global $uploads;

/*$uploads = [
	'upload_folder' => 'uploads',
	'separator' => '/',
	'app_path' => '/home/php/web/php.codingheads.com/public_html',
	'web_path' => '//php.codingheads.com/'
];
*/


function upload_image($field_name = 'image', $type = '') {

	global $uploads;

	$uploadOk = 0;


	/**
	 * Verificam daca exista folderul pe server
	 */	if (!file_exists($uploads['app_path'] . $uploads['separator'] . $uploads['upload_folder'])) {
		mkdir($uploads['app_path'] . $uploads['separator'] . $uploads['upload_folder']);
	}



	$link = $uploads['upload_folder'] . $uploads['separator'] . basename($_FILES[$field_name]['name']);

	$imageFileType = pathinfo($link, PATHINFO_EXTENSION);
	// $check = getimagesize($_FILES["image"]["tmp_name"]);



	// Allow certain file formats
	if(
		($imageFileType != "jpg") &&
		($imageFileType != "png") &&
		($imageFileType != "jpeg")	&&
		($imageFileType != "gif")
	) {

		$msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	} else {

		$uploadOk = 1;
	}


	if ($uploadOk) {

		if ($f = move_uploaded_file($_FILES[$field_name]['tmp_name'], $uploads['app_path'] . $uploads['separator'] . $link)) {

			return ['url' => $link, 'errors' => false];
		} else {

			$msg = 'Imaginea nu a putut fi mutata';
		}
	}


	return ['errors' => true, 'message' => $msg, 'url' => ''];
}




