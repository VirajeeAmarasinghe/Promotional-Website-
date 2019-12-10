<?php
   require_once('config/DBConnection.php');
   
   class Photo{
	   private $photoId;
	   private $photoTitle;
	   private $photo;
	   private $releaseId;
	   
	   //set methods
	   
	   public function setPhotoId($photoId){
		   $this->photoId=$photoId;
	   }
	   public function setPhotoTitle($title){
		   $this->photoTitle=$title;
	   }
	   public function setPhoto($photo){
		   $this->photo=$photo;
	   }
	   public function setReleaseId($releaseId){
		   $this->releaseId=$releaseId;
	   }
	   
	   //get methods
	   
	   public function getPhotoId(){
		   return $this->photoId;
	   }
	   public function getPhotoTitle(){
		   return $this->photoTitle;
	   }
	   public function getPhoto(){
		   return $this->photo;
	   }
	   public function getReleaseId(){
		   return $this->releaseId;
	   }
	   
	   //get photos according to the specific album
	   
	   public function getPhotosAccordingToReleaseId($releaseId){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT photo_id,photo_title,photo,release_id from release_photo where release_id='".$releaseId."'"; 
			  $result=$conn->query($myQuery);
			  $photos=array();
			  foreach($result as $photo){
				  $p1=new Photo();
				  $p1->setPhotoId($photo["photo_id"]);
				  $p1->setPhotoTitle($photo["photo_title"]);
				  $p1->setPhoto($photo["photo"]);
				  $p1->setReleaseId($photo["release_id"]);
				  array_push($photos,$p1);
			  }
			  $conn=null;
			  return $photos;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   }
	   
	   //get photos according to the specific photo id
	   
	   public function getPhotosAccordingToPhotoID($photoID){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT photo_id,photo_title,photo,release_id from release_photo where photo_id='".$photoID."'"; 
			  $result=$conn->query($myQuery);			  
			  $photo=new Photo();
			  if($result){
				  foreach($result as $photo2){				  				  
				  $photo->setPhotoId($photo2["photo_id"]);
				  $photo->setPhotoTitle($photo2["photo_title"]);
				  $photo->setPhoto($photo2["photo"]);
				  $photo->setReleaseId($photo2["release_id"]);				  
			      }
			  }			  			  
			  $conn=null;
			  return $photo;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   }
	   
	   //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(photo_id) AS max_value FROM release_photo";
			$max_result=$conn->prepare($queryForGetMaxId);
			$max_result->execute();
			$maxId = $max_result->fetch(PDO::FETCH_ASSOC);              
			$pId=$maxId['max_value']; 
			$incrementPid=$pId+1;
			return $incrementPid;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
     }
	 
	 //insert new photo to the database
	 public function addNewPhoto(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO release_photo(photo_title,photo,release_id)VALUES(:title,:photo,:rel_id)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':title',$this->getPhotoTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':photo',$this->getPhoto(),PDO::PARAM_STR);
			  $cmd->bindValue(':rel_id',$this->getReleaseId(),PDO::PARAM_INT);			  
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //this method is for updating photo details
	  public function updatePhotoDetails($photoID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE release_photo set photo_title=:title,photo=:photo,release_id=:rel_id where photo_id='".$photoID."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':title',$this->getPhotoTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':photo',$this->getPhoto(),PDO::PARAM_STR);
			  $cmd->bindValue(':rel_id',$this->getReleaseId(),PDO::PARAM_INT);
			  
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //delete specific photo
	  public function deletePhoto($photoID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM release_photo where photo_id='".$photoID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	    //get all the photos
	   
	   public function getPhotos(){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT photo_id,photo_title,photo,release_id from release_photo"; 
			  $result=$conn->query($myQuery);
			  $photos=array();
			  foreach($result as $photo){
				  $p1=new Photo();
				  $p1->setPhotoId($photo["photo_id"]);
				  $p1->setPhotoTitle($photo["photo_title"]);
				  $p1->setPhoto($photo["photo"]);
				  $p1->setReleaseId($photo["release_id"]);
				  array_push($photos,$p1);
			  }
			  $conn=null;
			  return $photos;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   }   
	   
   }
?>