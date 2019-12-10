<?php

  require_once('config/DBConnection.php');

  class SubBannerImage{
	  private $subBannerImageID;
	  private $subBannerImageName;
	  private $subBannerImageTitle;
	  private $fbShareUrl;
	  private $twitShareUrl;
	  private $googleShareUrl;
	  private $releaseId;
	  
	  //set methods
	  
	  public function setSubBannerImageId($id){
		  $this->subBannerImageID=$id;
	  }	
	  public function setSubBannerImageName($name){
		  $this->subBannerImageName=$name;
	  }
	  public function setSubBannerImageTitle($title){
		  $this->subBannerImageTitle=$title;
	  }
	  public function setFbShareUrl($fb){
		  $this->fbShareUrl=$fb;
	  }
	  public function setTwitShareUrl($twit){
		  $this->twitShareUrl=$twit;
	  } 
	  public function setGoogleShareUrl($google){
		  $this->googleShareUrl=$google;
	  }
	  public function setReleaseId($relId){
		  $this->releaseId=$relId;
	  } 
	  
	  //get methods
	  
	  public function getSubBannerImageId(){
		  return $this->subBannerImageID;
	  }	
	  public function getSubBannerImageName(){
		  return $this->subBannerImageName;
	  }
	  public function getSubBannerImageTitle(){
		  return $this->subBannerImageTitle;
	  }
	  public function getFbShareUrl(){
		  return $this->fbShareUrl;
	  }
	  public function getTwitShareUrl(){
		  return $this->twitShareUrl;
	  } 
	  public function getGoogleShareUrl(){
		  return $this->googleShareUrl;
	  }
	  public function getReleaseId(){
		  return $this->releaseId;
	  } 
	  
	  //get sub banner image according to specific release id (only one banner image is retrieved through this)
	  
	  public function getSubBannerImage($releaseId){
	
		  try{
			  $conn = DBConnection::GetConnection();
			  $myquery= "SELECT sub_banner_image_id,sub_banner_image_name,sub_banner_image_title,fb_share_url,twit_share_url,google_share_url,release_id FROM sub_banner_image where release_id='".$releaseId."' ";
			  $result= $conn->query($myquery);
			  
			  $subBannerImageArray=array();
			  
			  foreach($result as $item){
				    $s1= new SubBannerImage();							  
					$s1->setSubBannerImageId($item["sub_banner_image_id"]);		
				    $s1->setSubBannerImageName($item["sub_banner_image_name"]);
					$s1->setSubBannerImageTitle($item["sub_banner_image_title"]);
					$s1->setFbShareUrl($item["fb_share_url"]);
					$s1->setTwitShareUrl($item["twit_share_url"]);
					$s1->setGoogleShareUrl($item["google_share_url"]);
					$s1->setReleaseId($item["release_id"]);
					array_push($subBannerImageArray,$s1);
					break;
			  }
			  $conn =null;//To close the connection 
			  return $subBannerImageArray;
		  }catch(PDOException $e){
			  echo 'Fail to connect';
			  echo $e->getMessage();
	      }		
	}
	
	//get sub banners according to the specific sub banner id
	   
	   public function getBannersAccordingToBannerID($bannerID){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT sub_banner_image_id,sub_banner_image_name,sub_banner_image_title,fb_share_url, twit_share_url,google_share_url,release_id FROM sub_banner_image WHERE sub_banner_image_id='".$bannerID."'"; 
			  $result=$conn->query($myQuery);			  
			  $banner=new SubBannerImage();
			  if($result){
				  foreach($result as $photo2){				  				  
				       $banner->setSubBannerImageId($photo2["sub_banner_image_id"]);
					   $banner->setSubBannerImageName($photo2["sub_banner_image_name"]);
					   $banner->setSubBannerImageTitle($photo2["sub_banner_image_title"]);	
					   $banner->setFbShareUrl($photo2["fb_share_url"]);
					   $banner->setTwitShareUrl($photo2["twit_share_url"]);	
					   $banner->setGoogleShareUrl($photo2["google_share_url"]);  
					   $banner->setReleaseId($photo2["release_id"]);
			      }
			  }			  			  
			  $conn=null;
			  return $banner;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   }	
	
	  //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(sub_banner_image_id) AS max_value FROM sub_banner_image";
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
	 
	 //delete specific banner
	  public function deleteBanner($bannerID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM sub_banner_image where sub_banner_image_id='".$bannerID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //insert new banner to the database
	 public function addNewBanner(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO sub_banner_image(sub_banner_image_name,sub_banner_image_title, fb_share_url, twit_share_url,google_share_url,release_id) VALUES (:sub_banner_image_name,:sub_banner_image_title,:fb_share_url, :twit_share_url,:google_share_url,:release_id)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':sub_banner_image_name',$this->getSubBannerImageName(),PDO::PARAM_STR);
			  $cmd->bindValue(':sub_banner_image_title',$this->getSubBannerImageTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':fb_share_url',$this->getFbShareUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':twit_share_url',$this->getTwitShareUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':google_share_url',$this->getGoogleShareUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':release_id',$this->getReleaseId(),PDO::PARAM_INT);
			  		  
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //this method is for updating banner details
	  public function updatePhotoDetails($bannerID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE sub_banner_image SET sub_banner_image_name=:sub_banner_image_name,sub_banner_image_title=:sub_banner_image_title,fb_share_url=:fb_share_url,twit_share_url=:twit_share_url,google_share_url=:google_share_url,release_id=:release_id WHERE sub_banner_image_id='".$bannerID."'";
			  $cmd=$conn->prepare($updateQuery);
			  
			  $cmd->bindValue(':sub_banner_image_name',$this->getSubBannerImageName(),PDO::PARAM_STR);
			  $cmd->bindValue(':sub_banner_image_title',$this->getSubBannerImageTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':fb_share_url',$this->getFbShareUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':twit_share_url',$this->getTwitShareUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':google_share_url',$this->getGoogleShareUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':release_id',$this->getReleaseId(),PDO::PARAM_INT);
			  			  
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get all the banners
	   
	   public function getBanners(){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT sub_banner_image_id,sub_banner_image_name,sub_banner_image_title,fb_share_url, twit_share_url,google_share_url,release_id FROM sub_banner_image"; 
			  $result=$conn->query($myQuery);
			  $banners=array();
			  foreach($result as $photo){
				  $s1=new SubBannerImage();
				  $s1->setSubBannerImageId($photo["sub_banner_image_id"]);
				  $s1->setSubBannerImageName($photo["sub_banner_image_name"]);
				  $s1->setSubBannerImageTitle($photo["sub_banner_image_title"]);	
				  $s1->setFbShareUrl($photo["fb_share_url"]);
				  $s1->setTwitShareUrl($photo["twit_share_url"]);	
				  $s1->setGoogleShareUrl($photo["google_share_url"]);  
				  $s1->setReleaseId($photo["release_id"]);
				  array_push($banners,$s1);
			  }
			  $conn=null;
			  return $banners;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   }
  }
?>