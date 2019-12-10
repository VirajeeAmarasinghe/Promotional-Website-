<?php
   require_once('config/DBConnection.php');
   
   class AlbumCoverPhoto{
	   private $releaseId;
	   private $albumCoverPhoto;
	   
	   //set methods
	   
	   public function setReleaseId($id){
		   $this->releaseId=$id;
	   }
	   public function setAlbumCoverPhoto($photo){
		   $this->albumCoverPhoto=$photo;
	   }
	   
	   //get methods
	   
	   public function getReleaseId(){
		   return $this->releaseId;
	   }
	   public function getalbumCoverPhoto(){
		   return $this->albumCoverPhoto;
	   }
	   
	   //get album cover photo according to given release id(only one image is retrieved through this)
	   
	   public function GetPhotoAccordingToId($releaseId){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT release_id,album_cover_photo from album_cover_photo where release_id='".$releaseId."'";
			$result= $conn->query($myquery);
			$photos=array();
			foreach($result as $photo){
				$a1=new AlbumCoverPhoto();
				$a1->setReleaseId($photo["release_id"]);
				$a1->setAlbumCoverPhoto($photo["album_cover_photo"]);
			    array_push($photos,$a1);	
				break;			
			}
			$conn =null;//To close the connection 
			return $photos;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
   }
?>