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
	  private $coverImage;
	  
	  
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
	  public function setCoverImage($coverImage){
		  $this->coverImage=$coverImage;
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
	  public function getCoverImage(){
		  return $this->coverImage;
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
	 
	 //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(release_id) AS max_value FROM release_album";
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
	 
	 //insert new release to the database
	 public function addNewRelease(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO release_album(title,release_date,url_of_1D_store,url_of_googleplay,url_of_amazon,url_of_itunes)VALUES(:title,:rel_date,:oneD,:google,:amazon,:itunes)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':title',$this->getTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':rel_date',$this->getReleasedate(),PDO::PARAM_STR);
			  $cmd->bindValue(':oneD',$this->getUrlOfOneDStore(),PDO::PARAM_STR);
			  $cmd->bindValue(':google',$this->getUrlOfGooglePlay(),PDO::PARAM_STR);
			  $cmd->bindValue(':amazon',$this->getUrlOfAmazon(),PDO::PARAM_STR);
			  $cmd->bindValue(':itunes',$this->getUrlOfITunes(),PDO::PARAM_STR);
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //insert new banner images
	 public function addNewBannerImages(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO banner_image(release_id,banner_image)VALUES(:rel_id,:image)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':rel_id',$this->getReleaseID(),PDO::PARAM_INT);
			  $cmd->bindValue(':image',$this->getBannerImage(),PDO::PARAM_STR);			  
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //insert new cover images
	 public function addNewCoverImages(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO album_cover_photo(release_id,album_cover_photo)VALUES(:rel_id,:image)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':rel_id',$this->getReleaseID(),PDO::PARAM_INT);
			  $cmd->bindValue(':image',$this->getCoverImage(),PDO::PARAM_STR);			  
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //delete specific release
	  public function deleteRelease($releaseID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM release_album where release_id='".$releaseID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //this method is for updating release details
	  public function updatePersonalDetails($releaseID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE release_album set title=:title,release_date=:rel_date,url_of_1D_store=:oneD,url_of_googleplay=:google,url_of_amazon=:amazon,url_of_itunes=:itunes where release_id='".$releaseID."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':title',$this->getTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':rel_date',$this->getReleasedate(),PDO::PARAM_STR);
			  $cmd->bindValue(':oneD',$this->getUrlOfOneDStore(),PDO::PARAM_STR);
			  $cmd->bindValue(':google',$this->getUrlOfGooglePlay(),PDO::PARAM_STR);
			  $cmd->bindValue(':amazon',$this->getUrlOfAmazon(),PDO::PARAM_STR);
			  $cmd->bindValue(':itunes',$this->getUrlOfITunes(),PDO::PARAM_STR);
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  
  }
?>