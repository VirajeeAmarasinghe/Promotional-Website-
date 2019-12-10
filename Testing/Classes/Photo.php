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
	   
   }
?>