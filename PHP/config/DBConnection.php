<?php
  require_once('config/config.php');
  class DBConnection{
	  public static function getConnection(){
		  try{
			  $conn =new PDO('DB_DSN','DB_USERNAME','DB_PASSWORD');
			  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);					
			  return $conn;
		  }catch(PDOException $e){
			  echo 'Error'.$e->getMessage();
			  die(); //to stop the script
		  }
	  }
  }
?>