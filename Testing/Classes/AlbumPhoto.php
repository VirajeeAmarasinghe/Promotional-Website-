<?php
  require_once('config/DBConnection.php');

  class AlbumPhoto{
	  private $album_id;
	  private $album_name;
	  private $photo;
	  private $photos=array();
	  
	  //set methods
	  
	  public function setAlbumId($id){
		  $this->album_id=$id;
	  }
	  public function setAlbumName($album){
		  $this->album_name=$album;
	  }
	  public function setPhoto($photo){
		  $this->photo=$photo;
	  }
	  public function setPhotos($image){
		  array_push($this->photos,$image);
	  }
	  
	  //get methods
	  
	  public function getAlbumId(){
		  return $this->album_id;
	  }
	  public function getAlbumName(){
		  return $this->album_name;
	  }
	  public function getPhoto(){
		  return $this->photo;
	  }
	  public function getPhotos($index){
		  return $this->photos[$index];
	  }
	  
	  //get total photo album 
	  
	  public function getTotalNumberOfPhotoAlbums(){
		  try{
			 $conn=DBConnection::GetConnection();
			 $queryForGetTotal="SELECT COUNT(album_id) AS total_value FROM photo_album";
			 $tot_result=$conn->prepare($queryForGetTotal);
			 $tot_result->execute();
			 $tot= $tot_result->fetch(PDO::FETCH_ASSOC);              
			 $total=$tot['total_value'];  
			 $conn=null;
			 return $total;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get photo albums
	  
	  public function getPhotoAlbums($offset,$photo_per_page){
		  try{
			  $conn=DBConnection::GetConnection();
			  $sql ="SELECT album_id,album_name FROM photo_album LIMIT $offset,$photo_per_page";
			  $result=$conn->query($sql);
			  $photo_album=array();
			  
			  foreach($result as $photoAlbum){
				  $ph=new AlbumPhoto();
				  $ph->setAlbumId($photoAlbum['album_id']);
				  $albumId=$photoAlbum['album_id'];
				  $ph->setAlbumName($photoAlbum['album_name']);
				  $sqlQuery="select photo from photo where album_id='".$albumId."'";
				  $resultSet=$conn->query($sqlQuery);
				  foreach($resultSet as $photo){
					  $ph->setPhoto($photo['photo']);
					  break;
				  }
				  array_push($photo_album,$ph);
			  }
			  $conn=null;
			  return $photo_album;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get photo album name
	  
	  public function getPhotoAlbumName($albumId){
		  try{
			  $conn=DBConnection::GetConnection();
			  $sql ="SELECT album_name FROM photo_album where album_id='".$albumId."'";
			  $result=$conn->query($sql);
			  $albumName="";
			  foreach($result as $album){
				  $albumName=$album["album_name"];
			  }
			  $conn=null;
			  return $albumName;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get total number of photos for each photo album 
	  
	  public function getTotalNumberOfPhotos($albumId){
		  try{
			 $conn=DBConnection::GetConnection();
			 $queryForGetTotal="SELECT COUNT(*) AS total_value FROM photo where album_id='".$albumId."'";
			 $tot_result=$conn->prepare($queryForGetTotal);
			 $tot_result->execute();
			 $tot= $tot_result->fetch(PDO::FETCH_ASSOC);              
			 $total=$tot['total_value'];  
			 $conn=null;
			 return $total;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get all the photos in each album according to album id
	  
	  public function getAllThePhotosAccordingTolAlbum($offset,$photo_per_page,$albumId){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT photo FROM photo WHERE album_id='".$albumId."' LIMIT $offset,$photo_per_page";
			  $result=$conn->query($myQuery);
			  foreach($result as $image){
				  array_push($this->photos,$image['photo']);
			  }
			  $conn=null;
			  return $this->photos;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
  }
?>