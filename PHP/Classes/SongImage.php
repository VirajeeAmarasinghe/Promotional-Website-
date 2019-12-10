<?php
  require_once('config/DBConnection.php');
  
  class SongImage{
	  
	  private $songId;
	  private $songImage;
	  
	  //set methods
	  
	  public function setSongId($songId){
		   $this->songId=$songId;
	  }
	  public function setSongImage($image){
		   $this->songImage=$image;
	  }
	  
	  //get methods
	  
	  public function getSongId(){
		   return $this->songId;
	  }
	  public function getSongImage(){
		   return $this->songImage;
	  }
	  
	  //get song image according to song id
	   
	   public function getImageAccordingToId($songId){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT song_id,song_image from release_song_image where song_id='".$songId."'"; 
			  $result=$conn->query($myQuery);
			  $images=array();
			  foreach($result as $image){				  
				  array_push($images,$image["song_image"]);
			  }
			  $conn=null;
			  return $images;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   }
	   
	   //add new song Image
	  public function addNewSongImage(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO release_song_image(song_id,song_image) VALUES (:song_id,:song_image)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':song_id',$this->getSongId(),PDO::PARAM_INT);
			  $cmd->bindValue(':song_image',$this->getSongImage(),PDO::PARAM_STR);
			  			  
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     } 
	 
	 //delete specific song images
	  public function deleteSongImages($songID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM release_song_image WHERE song_id='".$songID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
  }
?>