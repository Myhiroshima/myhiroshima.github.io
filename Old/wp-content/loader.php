<?php
/**
 * PHP Restore MySQL Database
 */
require_once('../wp-database.php');

set_time_limit(0); // unlimited max execution time

$key = '123';

$database_url = '';

// $credential['host']	= DB_HOST;
// $credential['user']	= DB_USER;
// $credential['passwd'] 	= DB_PASSWORD;
// $credential['dbName'] 	= DB_NAME;

$dump_file = "/tmp/latest-database.sql";

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if($mysqli->connect_errno)
{
	echo "Connection failed: %s\n".$mysqli->connect_errno;
	exit();
}
else
{
	if(isset($_GET['key']) && $_GET['key'] == $key)
	{

    $database_url = escape_url($_GET['url']);

    download_database($database_url, $dump_file);
		restore_now($dump_file);
	}
}

/**
 * Functions
 */
function escape_url($url){

  return $url;
}

function download_database($database_url, $dump_file){

  //Delete current file if it already exists
  if(file_exists($dump_file)){
	unlink($dump_file);
  }

  // file handler
  $file = fopen($dump_file, 'w');
  // cURL
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$database_url);
  // set cURL options
  curl_setopt($ch, CURLOPT_FAILONERROR, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // set file handler option
  curl_setopt($ch, CURLOPT_FILE, $file);
  // execute cURL
  curl_exec($ch);
  // close cURL
  curl_close($ch);
  // close file
  fclose($file);
}

function restore_now($dump_file)
{
	drop_all_tables();
	restore_database($dump_file);

	echo "Restore database finished!";
}

function drop_all_tables()
{
	global $mysqli;

	$mysqli->query('SET foreign_key_checks = 0') or die($mysqli->error);

	if ($result = $mysqli->query("SHOW TABLES"))
	{
	    while($row = $result->fetch_array(MYSQLI_NUM))
	    {
	        $mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
	    }
	}

	$mysqli->query('SET foreign_key_checks = 1');
}

function restore_database($dump_file)
{
	global $credential;

	system("mysql -u{DB_USER} -p{DB_PASSWORD} {DB_NAME} < {$dump_file}");
}

