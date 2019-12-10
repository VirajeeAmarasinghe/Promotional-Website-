<?php
  require_once('config/DBConnection.php');
  
  class ReleaseAlbum{
	  private $releaseID;
	  private $title;
	  private $releaseDate;
	  private $urlOfOneDStore;
	  private $urlOfGooglePlay;
	  private $urlOfITunes;
	  private $urlOfAmazon;
	  private $bannerImage;
	  
	  
	  //set methods
	  public function setReleaseID($releaseID){
		  $this->releaseID=$releaseID;
	  }	  
	  public function setTitle($title){
		  $this->title=$title;
	  }
	  public function setReleaseDate($releaseDate){
		 $this->releaseDate=$releaseDate;
	  }	  
	  public function setUrlOfOneDStore($urlOfOneDStore){
		  $this->urlOfOneDStore=$urlOfOneDStore;
	  }
	  public function setUrlOfGooglePlay($urlOfGooglePlay){
		  $this->urlOfGooglePlay=$urlOfGooglePlay;
	  }
	  public function setUrlOfITunes($urlOfITunes){
		  $this->urlOfITunes=$urlOfITunes;
	  }
	  public function setUrlOfAmazon($urlOfAmazon){
		  $this->urlOfAmazon=$urlOfAmazon;
	  }
	  public function setBannerImage($bannerImage){
		  $this->bannerImage=$bannerImage;
	  }
	  
	  //get methods
	  public function getReleaseID(){
		  return $this->releaseID;
	  }
	  public function getTitle(){
		  return $this->title;
	  }
	  public function getReleasedate(){
		  return $this->releaseDate;
	  } 
	  public function getUrlOfOneDStore(){
		  return $this->urlOfOneDStore;
	  }
	  public function getUrlOfGooglePlay(){
		  return $this->urlOfGooglePlay;
	  }
	  public function getUrlOfITunes(){
		  return $this->urlOfITunes;
	  }
	  public function getUrlOfAmazon(){
		  return $this->urlOfAmazon;
	  }
	  public function getBannerImage(){
		  return $this->bannerImage;
	  }
	  
	  //get all releases data
	  
	  public function GetReleases(){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT release_id,title,release_date,url_of_1D_store,url_of_googleplay,url_of_amazon,url_of_itunes from release_album";
			$result= $conn->query($myquery);
			$releases=array();
			foreach($result as $release){
				$r1=new ReleaseAlbum();
				$r1->setReleaseID($release["release_id"]);
				$r1->setTitle($release["title"]);
				$r1->setReleaseDate($release["release_date"]);
				$r1->setUrlOfOneDStore($release["url_of_1D_store"]);
				$r1->setUrlOfGooglePlay($release["url_of_googleplay"]);
				$r1->setUrlOfAmazon($release["url_of_amazon"]);
				$r1->setUrlOfITunes($release["url_of_itunes"]);
				array_push($releases,$r1);								
			}
			$conn =null;//To close the connection 
			return $releases;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
	 
	 //get releases according to the specific release id
	 
	 public function GetReleasesAccordingToId($releaseId){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT release_id,title,release_date,url_of_1D_store,url_of_googleplay,url_of_amazon,url_of_itunes from release_album where release_id='".$releaseId."'";
			$result= $conn->query($myquery);
			$releases=array();
			foreach($result as $release){
				$r1=new ReleaseAlbum();
				$r1->setReleaseID($release["release_id"]);
				$r1->setTitle($release["title"]);
				$r1->setReleaseDate($release["release_date"]);
				$r1->setUrlOfOneDStore($release["url_of_1D_store"]);
				$r1->setUrlOfGooglePlay($release["url_of_googleplay"]);
				$r1->setUrlOfAmazon($release["url_of_amazon"]);
				$r1->setUrlOfITunes($release["url_of_itunes"]);
				array_push($releases,$r1);				
			}
			$conn =null;//To close the connection 
			return $releases;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
	 
	 //get banner image(only one banner image is retrived)
	 public function GetReleasesBannerImages($releaseID){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT release_id,banner_image from banner_image where release_id='".$releaseID."'";
			$result= $conn->query($myquery);
			$releases=array();
			foreach($result as $release){
				$r1=new ReleaseAlbum();
				$r1->setReleaseID($release["release_id"]);				
				$r1->setBannerImage($release["banner_image"]);
				array_push($releases,$r1);
				break;				
			}
			$conn =null;//To close the connection 
			return $releases;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
  }
?>