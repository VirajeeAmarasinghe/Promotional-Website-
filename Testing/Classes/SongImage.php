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
  }
?>